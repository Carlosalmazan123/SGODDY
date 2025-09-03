<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4" >
        <h2 class="text-2xl font-bold mb-4">Inventario</h2>
        
        <a href="{{ route('inventario.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Registrar movimiento</a>
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
                        <th class="px-4 py-2 text-left">Producto</th>
                    
                        <th class="px-4 py-2 text-left">Tipo Movimiento</th>
                        <th class="px-4 py-2 text-left">Stock</th>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($inventarios as $inventario)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 whitespace-nowrap">{{ $inventario->producto->nombre }}</td>
                           
                            <td class="px-4 py-2 capitalize whitespace-nowrap">{{ $inventario->tipo_movimiento }}</td>
                              <td class="px-4 py-2 whitespace-nowrap">{{ $inventario->stock }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $inventario->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-2">
                                    @can("inventario.edit")
                                    <a href="{{ route('inventario.edit', $inventario->id) }}"
                                       class="text-blue-500 hover:text-blue-600  text-xs  py-1 rounded"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                       @endcan
                                       @can("inventario.delete")
                                    <form action="{{ route('inventario.destroy', $inventario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-600  text-xs py-1 rounded"
                                                onclick="return confirm('¿Estás seguro de eliminar este movimiento?')">
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
                {{ $inventarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
