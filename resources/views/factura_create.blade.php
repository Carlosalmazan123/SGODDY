<x-app-layout>
    <div class="max-w-lg mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Registrar Factura</h1>

        <form action="{{ route('facturas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="paciente_id" class="block text-sm font-medium text-gray-700">Paciente</label>
                <select id="paciente_id" name="paciente_id"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="number" id="total" name="total" step="0.01"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <div>
                <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                <select id="metodo_pago" name="metodo_pago"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                    <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                </select>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="estado" name="estado"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="Pagado">Pagado</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300">
                Registrar Factura
            </button>
        </form>
    </div>
</x-app-layout>
