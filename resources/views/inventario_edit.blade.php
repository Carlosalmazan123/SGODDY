<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
        @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
        <h1 class="text-3xl font-semibold mb-4">Editar Movimiento de Inventario</h1>
    
        <form action="{{ route('inventario.update', $inventario->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Producto -->
                <div>
                    <label for="producto_id" class="block text-gray-700 font-medium">Producto*</label>
                    <select name="producto_id" id="producto_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $producto->id == $inventario->producto_id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Cantidad -->
                <div>
                    <label for="stock" class="block text-gray-700 font-medium">Cantidad*</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $inventario->stock) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('stock')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Tipo de Movimiento -->
                <div>
                    <label for="tipo_movimiento" class="block text-gray-700 font-medium">Tipo de Movimiento*</label>
                    <select name="tipo_movimiento" id="tipo_movimiento" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="entrada" {{ old('tipo_movimiento', $inventario->tipo_movimiento) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ old('tipo_movimiento', $inventario->tipo_movimiento) == 'salida' ? 'selected' : '' }}>Salida</option>
                        <option value="ajuste" {{ old('tipo_movimiento', $inventario->tipo_movimiento) == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                    </select>
                    @error('tipo_movimiento')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-gray-700 font-medium">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $inventario->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Botones -->
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Actualizar</button>
                    <a href="{{ route('inventario.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Cancelar</a>
                </div>
            </div>
        </form>
    </div>    
    </div>
</x-app-layout>