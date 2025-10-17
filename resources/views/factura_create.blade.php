<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Registrar Recibo</h1>

                   @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
  <form  id="invoice-form"  action="{{ route('facturas.store') }}" method="POST" class="space-y-4">  @csrf
    <div>
        <label class="block text-gray-700 font-semibold text-sm sm:text-base">Detalle del recibo</label>
        <div>
            <label>
                Fecha:
            </label>
            <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
       
        <div class="overflow-x-auto max-h-80 overflow-y-auto mt-3">
            <table id="invoice-table" class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border px-4 py-2 text-gray-700">Artículo*</th>
                        <th class="border px-4 py-2 text-gray-700">Cantidad*</th>
                        <th class="border px-4 py-2 text-gray-700">Precio Unitario</th>
                        <th class="border px-4 py-2 text-gray-700">Subtotal</th>
                        <th class="border px-4 py-2 text-gray-700">Fecha vencimiento</th>
                    </tr>
                </thead>
                <tbody>
<tr class="border border-gray-300 text-center">
    {{-- Item (Producto o Servicio) --}}
    <td class="p-2 border">
        <select name="item_id[]" data-index="0" required class="item-select w-full p-2 border rounded-md">
    <option value="">Seleccione un producto o servicio</option>

    <optgroup label="Productos">
        @foreach($productos as $producto)
            <option value="p-{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-check="{{ $producto->check ? 1 : 0 }}" data-stock="{{ $producto->stock_actual }}">
             {{ $producto->nombre }}
            </option>
        @endforeach
    </optgroup>

    <optgroup label="Servicios">
        @foreach($servicios as $servicio)
            <option value="s-{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" >
                {{ $servicio->nombre }}
            </option>
        @endforeach
    </optgroup>
</select>

    </td>
<td class="p-2 border relative">
    <input 
        type="number" 
        name="cantidad[]" 
        required 
        min="1"
        data-index="0"
        class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
        value="{{ old('cantidad.0') }}"
        step="1" 
        
    >
    <!-- burbuja / aviso (oculto por defecto) -->
    <p class="stock-warning absolute bg-red-500 text-white text-xs rounded-md px-2 py-1 mt-1 hidden">
    
    </p>
</td>
    {{-- Precio Unitario --}}
    <td class="p-2 border">
        <input type="number" name="precio_unitario[]" required step="0.01" min="0"  readonly
            data-index="0"
            class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            value="{{ old('precio_unitario.0') }}">
    </td>

    {{-- Subtotal --}}
    <td class="p-2 border">
        <input type="number" name="subtotal[]" step="0.01" min="0"
            data-index="0"
            class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"  readonly
            value="{{ old('subtotal.0') }}">
    </td>
    <td class="p-2 border">
        <input type="checkbox" name="check[]"
            data-index="0"
            class="check p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            value="{{ old('check.0') }}">
    </td>
  
</tr>
</tbody>
<tfoot>
    <tr class="bg-gray-50 text-right">
        <td colspan="3" class="px-4 py-2 font-semibold text-gray-700">Total:</td>
        <td class="px-4 py-2">
            <input type="number" name="total" id="total" readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-md p-2 text-gray-800 font-semibold">
        </td>
    </tr>
</tfoot>

            </table>
        </div>

        <button type="button" id="add-row" class="mt-2 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-200">
            Agregar Fila
        </button>
        <button type="button" id="remove-row" class="mt-2 ml-4 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition duration-200">
            Eliminar Última Fila
        </button>
    </div>

    <button type="submit" class="w-full sm:w-auto py-2 px-6 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">
        Generar Recibo
    </button>
</form>
    </div>
    </div>
  <script>
    const productos = @json($productosJson);
const servicios = @json($serviciosJson);
const facturaForm = document.getElementById('invoice-form');
function registrarEventos() {
    function parseStockFromOption(option) {
        if (!option) return NaN;
        const ds = option.dataset;
        if (ds.stock !== undefined && ds.stock !== '') {
            return parseFloat(ds.stock);
        }
        try {
            const val = option.value || '';
            if (val.startsWith('p-') && typeof productos !== 'undefined' && Array.isArray(productos)) {
                const id = parseInt(val.split('-')[1]);
                const prod = productos.find(p => parseInt(p.id) === id);
                if (prod && prod.stock !== undefined) return parseFloat(prod.stock);
            }
        } catch (e) { /* ignore */ }
        return NaN;
    }

    function formatStockForDisplay(stock, allowDecimals) {
        if (isNaN(stock)) return '';
        return allowDecimals ? parseFloat(stock).toFixed(2) : Math.floor(stock);
    }

    function calcularCantidadTotalProducto(productId) {
        let total = 0;
        document.querySelectorAll('.item-select').forEach(sel => {
            const val = sel.value;
            if (val === productId) {
                const index = sel.dataset.index;
                const cantidad = parseFloat(document.querySelector(`.cantidad[data-index="${index}"]`)?.value || 0);
                total += isNaN(cantidad) ? 0 : cantidad;
            }
        });
        return total;
    }

    // --- sanitiza en BLUR / PASTE (no en cada input) para evitar "parpadeos" mientras se escribe
    function sanitizarCantidadEnBlur(input) {
        if (!input) return;
        let raw = (input.value || '').toString().trim();
        if (raw === '') return;
        raw = raw.replace(',', '.');

        const num = parseFloat(raw);
        if (isNaN(num)) {
            input.value = '';
            return;
        }

        if (input.step === "1") {
            // forzar entero positivo
            input.value = String(Math.floor(Math.abs(num)));
        } else {
            // permitir hasta 1 decimal, pero mostrar sin .0 si es entero
                const redondeado = Math.round(num * 100) / 100;
                input.value = (redondeado % 1 === 0)
                    ? String(Math.floor(redondeado))
                    : redondeado.toFixed(2);
        }
    }

    // --- attach handlers para keydown/paste/blur por cada input cantidad (solo una vez)
    function attachCantidadInputHandlers(input) {
        if (!input || input.dataset.handlersAttached) return;
        // keydown: permite solo lo necesario según step
        // keydown: permite solo lo necesario según step (compatible con móviles)
input.addEventListener('beforeinput', function (e) {
    const inputType = e.inputType || '';
    const data = e.data || '';

    // permitir eliminación o navegación
    if (inputType.startsWith('delete')) return;

    // si es step = 1 => solo números enteros
    if (this.step === "1") {
        if (!/^[0-9]$/.test(data) && data !== '') {
            e.preventDefault();
        }
    } else {
        // permitir dígitos y solo un punto o coma
        if (data === '.' || data === ',') {
            if (this.value.includes('.') || this.value.includes(',')) {
                e.preventDefault();
            }
        } else if (data && !/^[0-9]$/.test(data)) {
            e.preventDefault();
        }
    }
});


        // paste: sanitizar contenido pegado
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text') || '';
            let cleaned = pasted.replace(',', '.').replace(/[^0-9.]/g, '');
            // dejar solo el primer punto
            if ((cleaned.match(/\./g) || []).length > 1) {
                const parts = cleaned.split('.');
                cleaned = parts.shift() + '.' + parts.join('');
            }
            if (this.step === "1") {
                cleaned = cleaned.split('.')[0] || '';
            } else {
                // limitar a 2 decimales
               if (cleaned) {
                    const n = parseFloat(cleaned);
                    if (!isNaN(n)) {
                        const redondeado = Math.round(n * 100) / 100;
                        cleaned = (redondeado % 1 === 0)
                            ? String(Math.floor(redondeado))
                            : redondeado.toFixed(2);
                    }
                }

            }
            this.value = cleaned;
            // disparar input para recalcular subtotal/validaciones
            this.dispatchEvent(new Event('input', { bubbles: true }));
            // también disparar blur sanitizador si quieres
        });

        // blur: aplicar sanitización final
        input.addEventListener('blur', function () {
            sanitizarCantidadEnBlur(this);
            this.dispatchEvent(new Event('input', { bubbles: true }));
        });
        // input event (para móviles que no disparan blur correctamente)
input.addEventListener('change', function () {
    sanitizarCantidadEnBlur(this);
    this.dispatchEvent(new Event('input', { bubbles: true }));
});


        input.dataset.handlersAttached = '1';
    }

    function validarStockGlobal(itemId, input, warningEl, stockDisponible) {
        if (!itemId || !itemId.startsWith('p-') || isNaN(stockDisponible)) {
            if (warningEl) warningEl.classList.add('hidden');
            if (input) input.setCustomValidity('');
            return;
        }

        const totalProducto = calcularCantidadTotalProducto(itemId);
        const display = formatStockForDisplay(stockDisponible, input && input.step === "0.01");

        if (totalProducto > stockDisponible) {
            if (typeof mostrarAdvertenciaStock === 'function' && input) {
                mostrarAdvertenciaStock(input, `Stock insuficiente. Disponible: ${display}`);
            }
           
            if (input) input.setCustomValidity('Cantidad total excede el stock disponible');
        } else {
            if (warningEl) warningEl.classList.add('hidden');
            if (input) input.setCustomValidity('');
        }
    }

    function onSelectChangeEvent(evOrSelect) {
        const select = evOrSelect.currentTarget || evOrSelect;
        const index = select.dataset.index;
        const option = select.selectedOptions[0] || {};
        const precio = parseFloat(option.dataset.precio || 0);
        const checkValor = parseInt(option.dataset.check || 0) || 0;
        const stockDisponible = parseStockFromOption(option);
        const itemId = select.value;

        const cantidadInput = document.querySelector(`.cantidad[data-index="${index}"]`);
        const precioInput = document.querySelector(`.precio-unitario[data-index="${index}"]`);
        const subtotalInput = document.querySelector(`.subtotal[data-index="${index}"]`);
        const checkInput = document.querySelector(`.check[data-index="${index}"]`);
        const warningEl = cantidadInput ? cantidadInput.closest('td').querySelector('.stock-warning') : null;

        if (precioInput) precioInput.value = precio.toFixed(2);

        if (cantidadInput) {
            if (!isNaN(stockDisponible)) {
                cantidadInput.dataset.stockMax = stockDisponible;
                cantidadInput.max = stockDisponible;
            } else {
                delete cantidadInput.dataset.stockMax;
                cantidadInput.removeAttribute('max');
            }

            // establecer step según checkValor
            cantidadInput.step = checkValor === 1 ? "0.01" : "1";

            // adjuntar handlers (solo la primera vez)
            attachCantidadInputHandlers(cantidadInput);

            // Si el campo ya contiene un valor y ahora pasó a step=1, lo sanitizamos (evitar decimales)
            sanitizarCantidadEnBlur(cantidadInput);

            // validar stock global inicial
            validarStockGlobal(itemId, cantidadInput, warningEl, stockDisponible);
        }

        if (subtotalInput && cantidadInput) {
            const cantidad = parseFloat(cantidadInput.value || 0);
            subtotalInput.value = (cantidad * precio).toFixed(2);
        }

        if (checkInput) checkInput.checked = checkValor === 1;

        calcularTotal();
    }

    function onCantidadInputEvent(ev) {
        const input = ev.currentTarget;
        const index = input.dataset.index;
        // no sanitizamos aquí agresivamente para no romper la escritura; sanitizamos en blur/paste
        const cantidad = parseFloat(input.value || 0);
        const precio = parseFloat(document.querySelector(`.precio-unitario[data-index="${index}"]`)?.value || 0);
        const subtotalInput = document.querySelector(`.subtotal[data-index="${index}"]`);
        const select = document.querySelector(`.item-select[data-index="${index}"]`);
        const option = select?.selectedOptions[0];
        const warningEl = input.closest('td')?.querySelector('.stock-warning');
        const stockMax = parseStockFromOption(option);
        const itemId = select?.value || '';

        if (subtotalInput) subtotalInput.value = (cantidad * precio).toFixed(2);

        validarStockGlobal(itemId, input, warningEl, stockMax);

        calcularTotal();
    }

    // Inicializar eventos (re-aplicable para filas nuevas)
    document.querySelectorAll('.item-select').forEach(select => {
        if (!select.dataset.listenerAdded) {
            select.addEventListener('change', onSelectChangeEvent);
            select.dataset.listenerAdded = '1';
        }
        // inicializar estado actual
        onSelectChangeEvent(select);
    });

    document.querySelectorAll('.cantidad').forEach(input => {
        if (!input.dataset.listenerAddedInput) {
            input.addEventListener('input', onCantidadInputEvent);
            input.dataset.listenerAddedInput = '1';
        }
        // asegurarse de tener handlers de teclado/paste/blur
        attachCantidadInputHandlers(input);
    });
}

    document.getElementById('add-row').addEventListener('click', function () {
        const existingRows = document.querySelectorAll('#invoice-table tbody tr');
        const index = existingRows.length;
registrarEventos();
        if (index < 20) {
            const newRow = document.createElement('tr');
            newRow.classList.add('border', 'border-gray-300', 'text-center');

            newRow.innerHTML = `
                {{-- Item (Producto o Servicio) --}}
    <td class="p-2 border">
        <select name="item_id[]" data-index="${index}" required class="item-select w-full p-2 border rounded-md">
            <option value="">Seleccione un producto o servicio</option>
            
            <optgroup label="Productos">
                @foreach($productos as $producto)
                    <option value="p-{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-check="{{ $producto->check }}" data-stock="{{ $producto->stock_actual }}">
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </optgroup>

            <optgroup label="Servicios">
                @foreach($servicios as $servicio)
                    <option value="s-{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" data-check="0">
                        {{ $servicio->nombre }}
                    </option>
                @endforeach
            </optgroup>
        </select>
    </td>

           <td class="p-2 border">
    <div class="relative">
        <input 
            type="number" 
            name="cantidad[]" 
            required 
            min="1" 
            data-index="${index}"
            class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            step="1"
            value="">
        <p class="stock-warning text-sm text-red-600 mt-1 hidden" data-index="${index}"></p>
    </div>
</td>

                <td class="p-2 border">
                    <input type="number" name="precio_unitario[]" required step="0.01" min="0" data-index="${index}" class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
                </td>

                <td class="p-2 border">
                    <input type="number" name="subtotal[]" step="0.01" min="0" data-index="${index}" class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
                </td>
                <td class="p-2 border">
                    <input type="checkbox" name="check[]"  data-index="${index}" class="check  p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
                </td>

                
            `;

            document.querySelector('#invoice-table tbody').appendChild(newRow);
        } else {
            alert("Llegaste al número máximo de filas");
        }
    });

    document.getElementById('remove-row').addEventListener('click', function () {
        const existingRows = document.querySelectorAll('#invoice-table tbody tr');
        if (existingRows.length > 1) {
            existingRows[existingRows.length - 1].remove();
        } else {
            alert("Debe haber al menos una fila");
        }
    });
function calcularTotal() {
    let total = 0;
    document.querySelectorAll('input[name="subtotal[]"]').forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) total += valor;
    });
    const totalEl = document.getElementById('total');
    if (totalEl) totalEl.value = total.toFixed(2);
}

// validación final antes de enviar: evita envío si hay cantidades inválidas respecto al stock
if (facturaForm) {
    facturaForm.addEventListener('submit', function (e) {
        // force check validity on all cantidad inputs
        let invalid = false;
        document.querySelectorAll('.cantidad').forEach(input => {
            input.reportValidity(); // muestra mensajes nativos si existe customValidity
            if (!input.checkValidity()) invalid = true;
        });

        if (invalid) {
            e.preventDefault();
            // también podemos mostrar un alert o foco en primer inválido
            const firstInvalid = document.querySelector('.cantidad:invalid');
            if (firstInvalid) firstInvalid.focus();
            return false;
        }
        // si pasa, el servidor volverá a validar el stock (como ya lo haces en store)
    });
}

window.addEventListener('DOMContentLoaded', function () {
    registrarEventos();
    calcularTotal();

    const addRowBtn = document.getElementById('add-row');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            registrarEventos();
            calcularTotal();
        });
    }
});

   function mostrarAdvertenciaStock(input, mensaje) {
    let warning = document.querySelector('.stock-warning-global');

    if (!warning) {
        warning = document.createElement('p');
        warning.className = 'stock-warning stock-warning-global hidden';
        document.body.appendChild(warning);
    }

    warning.textContent = mensaje;
    warning.classList.remove('hidden');

    // Posiciona la burbuja sobre el input
    const rect = input.getBoundingClientRect();
    warning.style.left = `${rect.left - rect.width}px`;
    warning.style.top = `${rect.top + 30}px`;

    // Oculta la advertencia después de unos segundos
    clearTimeout(warning.timeout);
    warning.timeout = setTimeout(() => {
        warning.classList.add('hidden');
    }, 2000);
}
</script>

<style>
    .stock-warning {
    position: fixed !important;
    z-index: 99999 !important;
    background: rgba(239, 68, 68, 0.95); /* rojo semitransparente */
    color: white;
    font-size: 0.75rem;
    border-radius: 0.375rem;
    padding: 0.25rem 0.5rem;
    pointer-events: none;
    transform: translate(10%, 10%);
    white-space: nowrap;
    transition: opacity 0.2s ease;
}

</style>
</x-app-layout>
