<x-app-layout>
 
        <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4" >
            <h2 class="text-2xl font-bold mb-4">Productos</h2>
            
            <a href="{{ route('productos.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Agregar Producto</a>
            @if (session('success'))
            <div id="success-message" class="mt-3 p-2 bg-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        
            <script>
                // Desaparecer el mensaje después de 1 segundo
                setTimeout(function() {
                    let message = document.getElementById('success-message');
                    if (message) {
                        message.style.display = 'none';
                    }
                }, 1000); // 1000 ms = 1 segundo
            </script>
        @endif
       <div class="bg-white mt-3 shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="border px-4 py-2 text-left">Nombre</th>
                        <th class="border px-4 py-2 text-left">Categoría</th>
                        <th class="border px-4 py-2 text-left">Precio</th>
                   
                        <th class="border px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($productos as $producto)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 whitespace-nowrap">{{ $producto->nombre }}</td>
                            <td class="border px-4 py-2 whitespace-nowrap">{{ $producto->categoria->nombre }}</td>
                            <td class="border px-4 py-2 whitespace-nowrap">Bs {{ number_format($producto->precio, 2) }}</td>
                         
                            <td class="border px-4 py-2">
                                <div class="flex flex-wrap gap-2">
                                    @can("producto.show")
                                    <a href="{{ route('productos.show', $producto) }}"
                                       class="text-green-500 hover:text-green-600  text-xs  py-1 rounded" ><ion-icon name="eye-outline" class="h-6 w-6"></ion-icon></a>
                                       @endcan
                                       @can("producto.edit")
                                    <a href="{{ route('productos.edit', $producto) }}"
                                       class="text-blue-500 hover:text-blue-600  text-xs  py-1 rounded" ><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                        @endcan
                                    @can("producto.delete")
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-600 text-xs  py-1 rounded"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminarlo?')">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            </div>
        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</x-app-layout>
