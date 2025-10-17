<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar Recibo</h1>

            @if($errors->any())
                <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('facturas.update', $factura->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-gray-700 font-semibold text-sm sm:text-base">Detalle del recibo</label>
                    <div>
                        <label>Fecha:</label>
                        <input type="date" name="fecha" value="{{ old('fecha', $factura->fecha->format('Y-m-d')) }}"
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
                                    <th class="border px-4 py-2 text-gray-700">Fecha Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($factura->detalles as $index => $detalle)
    <tr class="border border-gray-300 text-center">
        <td class="p-2 border">
            <select name="item_id[]" data-index="{{ $index }}" required class="item-select w-full border rounded p-2">
                <option value="">Seleccione un producto o servicio</option>
                <optgroup label="Productos">
                    @foreach($productos as $p)
                        <option value="p-{{ $p->id }}" 
                                data-precio="{{ $p->precio }}"
                                data-check="{{ $p->check }}"
                            {{ old('item_id.'.$index, $detalle->producto_id ? 'p-'.$detalle->producto_id : '') == 'p-'.$p->id ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Servicios">
                    @foreach($servicios as $s)
                        <option value="s-{{ $s->id }}" 
                                data-precio="{{ $s->precio }}"
                                data-check="0"
                            {{ old('item_id.'.$index, $detalle->servicio_id ? 's-'.$detalle->servicio_id : '') == 's-'.$s->id ? 'selected' : '' }}>
                            {{ $s->nombre }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
        </td>

        <td class="p-2 border">
    <input 
        type="number" 
        name="cantidad[]" 
        required 
        min="1"
        data-index="{{ $index }}"
        class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
        value="{{ old('cantidad.'.$index, $detalle->cantidad) }}"
        step="1">
</td>


        <td class="p-2 border">
            <input type="number" name="precio_unitario[]" required step="0.01" min="0"
                   data-index="{{ $index }}"
                   class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                   value="{{ old('precio_unitario.'.$index, $detalle->producto?->precio ?? $detalle->servicio?->precio) }}">
        </td>

        <td class="p-2 border">
            <input type="number" name="subtotal[]" step="0.01" min="0"
                   data-index="{{ $index }}"
                   class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                   value="{{ old('subtotal.'.$index, $detalle->subtotal) }}">
        </td>

        <td class="p-2 border">
            <input type="checkbox" name="check[]" data-index="{{ $index }}"
                   class="check p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                   {{ $detalle->producto?->check ? 'checked' : '' }}>
        </td>
    </tr>
@endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50 text-right">
                                     <td colspan="3" class="px-4 py-2 font-semibold text-gray-700">Total:</td>
        <td class="px-4 py-2">
                                        <input type="number" name="total" id="total" readonly
                                               class="w-full bg-gray-100 border border-gray-300 rounded-md p-2 text-gray-800 font-semibold"
                                               value="{{ old('total', $factura->total) }}">
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
                    Actualizar Recibo
                </button>
            </form>
        </div>
    </div>

    <script>
document.getElementById('add-row').addEventListener('click', function () {
    const existingRows = document.querySelectorAll('#invoice-table tbody tr');
    const index = existingRows.length;

    if (index < 20) {
        const newRow = document.createElement('tr');
        newRow.classList.add('border', 'border-gray-300', 'text-center');

        newRow.innerHTML = `
<td class="p-2 border">
    <select name="item_id[]" data-index="${index}" required class="item-select w-full p-2 border rounded-md">
        <option value="">Seleccione un producto o servicio</option>
        <optgroup label="Productos">
            @foreach($productos as $producto)
                <option value="p-{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-check="{{ $producto->check }}">
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
    <input 
        type="number" 
        name="cantidad[]" 
        required 
        min="1" 
        data-index="${index}"
        class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
        step="1">
</td>

<td class="p-2 border">
    <input type="number" name="precio_unitario[]" required step="0.01" min="0" data-index="${index}"
           class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
</td>

<td class="p-2 border">
    <input type="number" name="subtotal[]" step="0.01" min="0" data-index="${index}"
           class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
</td>

<td class="p-2 border">
    <input type="checkbox" name="check[]" data-index="${index}"
           class="check p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
</td>
        `;

        document.querySelector('#invoice-table tbody').appendChild(newRow);

        // Registrar eventos en la nueva fila
        registrarEventos();
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

function registrarEventos() {
    document.querySelectorAll('.item-select').forEach(select => {
        if (!select.dataset.listenerAdded) {
            select.addEventListener('change', function () {
                const index = this.dataset.index;
                const precio = parseFloat(this.selectedOptions[0]?.dataset.precio || 0);
                const checkValor = parseInt(this.selectedOptions[0]?.dataset.check || 0);
                const cantidadInput = document.querySelector(`.cantidad[data-index="${index}"]`);
                const precioInput = document.querySelector(`.precio-unitario[data-index="${index}"]`);
                const subtotalInput = document.querySelector(`.subtotal[data-index="${index}"]`);
                const checkInput = document.querySelector(`.check[data-index="${index}"]`);

                if (precioInput) precioInput.value = precio.toFixed(2);

                if (cantidadInput && subtotalInput) {
                    const cantidad = parseFloat(cantidadInput.value || 0);
                    subtotalInput.value = (cantidad * precio).toFixed(2);
                }

                if (checkInput) checkInput.checked = checkValor === 1;

                if (cantidadInput) {
                    if (checkValor === 1) {
                        cantidadInput.step = "0.01";
                    } else {
                        cantidadInput.step = "1";
                        cantidadInput.value = Math.floor(parseFloat(cantidadInput.value || 1));
                    }
                }

                calcularTotal();
            });
            select.dataset.listenerAdded = true;
        }

        // Ajustar step y checkbox al cargar la página (vista edit)
        const index = select.dataset.index;
        const checkValor = parseInt(select.selectedOptions[0]?.dataset.check || 0);
        const cantidadInput = document.querySelector(`.cantidad[data-index="${index}"]`);
        const checkInput = document.querySelector(`.check[data-index="${index}"]`);

        if (cantidadInput) {
            cantidadInput.step = checkValor === 1 ? "0.01" : "1";
            if (checkValor === 0) cantidadInput.value = Math.floor(parseFloat(cantidadInput.value || 1));
        }
        if (checkInput) checkInput.checked = checkValor === 1;
    });

    document.querySelectorAll('.cantidad').forEach(input => {
        if (!input.dataset.listenerAdded) {
            input.addEventListener('input', function () {
                const index = this.dataset.index;
                const cantidad = parseFloat(this.value || 0);
                const precio = parseFloat(document.querySelector(`.precio-unitario[data-index="${index}"]`)?.value || 0);
                const subtotalInput = document.querySelector(`.subtotal[data-index="${index}"]`);

                if (subtotalInput) subtotalInput.value = (cantidad * precio).toFixed(2);
                calcularTotal();
            });
            input.dataset.listenerAdded = true;
        }
    });
}

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('input[name="subtotal[]"]').forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) total += valor;
    });
    document.getElementById('total').value = total.toFixed(2);
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
</script>

</x-app-layout>
