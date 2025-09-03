<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md -gray-800">
        <h1 class="text-2xl font-bold text-gray-800 -white mb-6">Registrar Producto</h1>
    
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 -gray-300">Nombre</label>
                    <input type="text" name="nombre" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 -gray-700 -white" required>
                </div>
    
                <div>
                    <label class="block text-gray-700 -gray-300">Categoría</label>
                    <select name="categoria_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 -gray-700 -white" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div>
                    <label class="block text-gray-700 -gray-300">Precio</label>
                    <input type="number" name="precio" step="0.01" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 -gray-700 -white" required>
                </div>
    
                
    
               
    
                <div>
                    <label class="block text-gray-700 -gray-300">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 -gray-700 -white">
                </div>
    
                <div>
                    <label class="block text-gray-700 -gray-300">Proveedor</label>
                    <select name="proveedor_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 -gray-700 -white">
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div>
                    <label class="block text-gray-700 ">Imagen</label>
                    <input type="file" name="imagen" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 text-white">
                </div>
            </div>
    
            <button type="submit" class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Guardar Producto
            </button>
        </form>
    </div>
</x-app-layout>