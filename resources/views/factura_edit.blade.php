<x-app-layout>
 
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar Factura</h1>
    
        <form action="{{ route('facturas.update', $factura->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
    
            <div>
                <label for="paciente_id" class="block text-lg font-medium text-gray-700 mb-1">Paciente</label>
                <select id="paciente_id" name="paciente_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                    @foreach ($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ $factura->paciente_id == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div>
                <label for="total" class="block text-lg font-medium text-gray-700 mb-1">Total</label>
                <input type="number" id="total" name="total" step="0.01" value="{{ $factura->total }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
    
            <div>
                <label for="metodo_pago" class="block text-lg font-medium text-gray-700 mb-1">Método de Pago</label>
                <select id="metodo_pago" name="metodo_pago"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="Efectivo" {{ $factura->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Tarjeta de Crédito" {{ $factura->metodo_pago == 'Tarjeta de Crédito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                    <option value="Transferencia Bancaria" {{ $factura->metodo_pago == 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia Bancaria</option>
                </select>
            </div>
            
    
            <div>
                <label for="estado" class="block text-lg font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                    <option value="Pagado" {{ $factura->estado == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="Pendiente" {{ $factura->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>
    
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-600 transition-all">
                    Actualizar Factura
                </button>
                <a href="{{ route('facturas.index') }}" class="bg-gray-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-gray-600 transition-all">
                    Cancelar
                </a>
            </div>
        </form>
    </div>    
    </div>
</x-app-layout>
