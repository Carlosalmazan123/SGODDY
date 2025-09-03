<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4" >
      
        <h2 class="text-2xl font-bold mb-4">Categorías</h2>
        
        <a href="{{ route('categorias.create') }}" class="px-4 py-2 mb-4 bg-blue-500 text-white rounded">+Agregar Categoría</a>
        

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
        <div  class="overflow-x-auto overflow-hidden ">
        <table class="w-full mt-4 border-collapse border  ">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categorias as $categoria)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 whitespace-nowrap">{{ $categoria->nombre }}</td>
                            <td class="px-4 py-2 whitespace-normal">{{ $categoria->descripcion }}</td>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-2">
                                    @can('categoria.edit')
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                       class="text-blue-600 hover:underline text-sm" ><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                    @endcan
                                    @can('categoria.delete')
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline text-sm"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
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
            <div class="mt-4">
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
