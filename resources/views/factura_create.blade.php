<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Registrar Factura</h1>

                @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
  <form action="{{ route('facturas.store') }}" method="POST" class="space-y-4">  @csrf
    <div>
        <label class="block text-gray-700 font-semibold text-sm sm:text-base">Detalle de la Factura</label>
        <div>
            <label>
                Fecha:
            </label>
            <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
           <label class="p-2">Paciente</label>
    <select name="paciente_id" required class="w-2/3 mt-3 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
        <option >Seleccione un paciente</option>
        @foreach($pacientes as $paciente)
            <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
        @endforeach
    </select>
        </div>
        <div class="overflow-x-auto max-h-80 overflow-y-auto mt-3">
            <table id="invoice-table" class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border px-4 py-2 text-gray-700">Artículo</th>
                        <th class="border px-4 py-2 text-gray-700">Cantidad</th>
                        <th class="border px-4 py-2 text-gray-700">Precio Unitario</th>
                        <th class="border px-4 py-2 text-gray-700">Subtotal</th>
                    
                       
                    </tr>
                </thead>
                <tbody>
<tr class="border border-gray-300 text-center">
    {{-- Producto --}}
    <td class="p-2 border">
        <select name="producto_id[]" data-index="0" required class="producto-select w-full p-2 border rounded-md">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                
    </td>

    {{-- Cantidad --}}
    <td class="p-2 border">
        <input type="number" name="cantidad[]" required min="1"
            data-index="0"
            class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            value="{{ old('cantidad.0') }}">
    </td>

    {{-- Precio Unitario --}}
    <td class="p-2 border">
        <input type="number" name="precio_unitario[]" required step="0.01" min="0"
            data-index="0"
            class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            value="{{ old('precio_unitario.0') }}">
    </td>

    {{-- Subtotal --}}
    <td class="p-2 border">
        <input type="number" name="subtotal[]" step="0.01" min="0"
            data-index="0"
            class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
            value="{{ old('subtotal.0') }}">
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
        Generar Factura
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
                    <select name="producto_id[]" required data-index="${index}" class="producto-select w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
                            <option value="">Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                                    {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                </td>

                <td class="p-2 border">
                    <input type="number" name="cantidad[]" required min="1" data-index="${index}" class="cantidad w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
                </td>

                <td class="p-2 border">
                    <input type="number" name="precio_unitario[]" required step="0.01" min="0" data-index="${index}" class="precio-unitario w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
                </td>

                <td class="p-2 border">
                    <input type="number" name="subtotal[]" step="0.01" min="0" data-index="${index}" class="subtotal w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" readonly>
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

     function registrarEventos() {
    // Cambiar precio automáticamente al seleccionar producto
    document.querySelectorAll('.producto-select').forEach(select => {
        if (!select.dataset.listenerAdded) {
            select.addEventListener('change', function () {
                const precio = this.selectedOptions[0].getAttribute('data-precio');
                const index = this.getAttribute('data-index');

                const precioInput = document.querySelector(`.precio-unitario[data-index='${index}']`);
                if (precioInput) {
                    precioInput.value = precio;

                    // Actualizar subtotal si hay cantidad
                    const cantidadInput = document.querySelector(`.cantidad[data-index='${index}']`);
                    const subtotalInput = document.querySelector(`.subtotal[data-index='${index}']`);

                    if (cantidadInput && subtotalInput) {
                        const cantidad = parseFloat(cantidadInput.value) || 0;
                        subtotalInput.value = (cantidad * parseFloat(precio)).toFixed(2);

                        // ✅ Recalcular total después de actualizar subtotal
                        calcularTotal();
                    }
                }
            });
            select.dataset.listenerAdded = true;
        }
    });

    // Cambiar subtotal automáticamente al modificar cantidad
    document.querySelectorAll('.cantidad').forEach(input => {
        if (!input.dataset.listenerAdded) {
            input.addEventListener('input', function () {
                const index = this.getAttribute('data-index');

                const precioInput = document.querySelector(`.precio-unitario[data-index='${index}']`);
                const subtotalInput = document.querySelector(`.subtotal[data-index='${index}']`);

                if (precioInput && subtotalInput) {
                    const cantidad = parseFloat(this.value) || 0;
                    const precio = parseFloat(precioInput.value) || 0;
                    subtotalInput.value = (cantidad * precio).toFixed(2);

                    // ✅ Recalcular total después de actualizar subtotal
                    calcularTotal();
                }
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

// Calcular al cargar por si hay datos antiguos
window.addEventListener('DOMContentLoaded', calcularTotal);

document.addEventListener('DOMContentLoaded', function () {
    registrarEventos();

    const addRowBtn = document.getElementById('add-row');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            // tu lógica para insertar una fila
            // luego:
            registrarEventos();
            calcularTotal(); // ✅ también calcula el total por si ya viene con datos
        });
    }
});

</script>
</x-app-layout>
