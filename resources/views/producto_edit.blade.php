<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Editar Producto</h1>
    
        <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="nombre" value="{{ $producto->nombre }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Categoría</label>
                    <select name="categoria_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Precio</label>
                    <input type="number" name="precio" value="{{ $producto->precio }}" step="0.01" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Stock</label>
                    <input type="number" name="stock" value="{{ $producto->stock }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Unidad de Medida</label>
                    <input type="text" name="unidad_medida" value="{{ $producto->unidad_medida }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" value="{{ $producto->fecha_vencimiento }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Proveedor</label>
                    <select name="proveedor_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Imagen</label>
                    <input type="file" name="imagen" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="mt-2 h-20 w-20 object-cover">
                    @endif
                </div>
            </div>
    
            <button type="submit" class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Actualizar Producto
            </button>
        </form>
    </div>    
</x-app-layout>