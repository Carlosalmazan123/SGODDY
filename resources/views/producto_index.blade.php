<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Productos</h2>
        <a href="{{ route('productos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Producto</a>
      
        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Categoría</th>
                    <th class="border p-2">Precio</th>
                    <th class="border p-2">Stock</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr class="border">
                    <td class="p-2">{{ $producto->nombre }}</td>
                    <td class="p-2">{{ $producto->categoria->nombre }}</td>
                    <td class="p-2">{{ $producto->precio }}</td>
                    <td class="p-2">{{ $producto->stock }}</td>
                    <td class="p-2">
                        <a href="{{ route('productos.show', $producto) }}" class="px-2 py-1 bg-green-500 text-white rounded">Ver</a>
                        <a href="{{ route('productos.edit', $producto) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        {{ $productos->links() }}
    </div>
</x-app-layout>