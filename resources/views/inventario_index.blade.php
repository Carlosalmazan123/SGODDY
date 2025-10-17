<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4">
        <h2 class="text-2xl font-bold mb-4">Inventario</h2>

        <a href="{{ route('inventario.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Registrar
            movimiento</a>
        <br>
        <button onclick="document.getElementById('modal-reporte').classList.remove('hidden')"
            class="text-white mt-2 bg-green-500 hover:bg-green-600 px-2 py-1 rounded inline-flex items-center ">
            <ion-icon name="document-text-outline" class="mr-2 text-xl"></ion-icon>
            Generar Reporte Inventario
        </button>
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
                            <th class="border px-4 py-2 text-left">Producto</th>

                            <th class="border px-4 py-2 text-left">Tipo Movimiento</th>
                            <th class="border px-4 py-2 text-left">Stock</th>
                            <th class="border px-4 py-2 text-left">Fecha</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($inventarios as $inventario)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 whitespace-nowrap">{{ $inventario->producto->nombre }}</td>

                                <td class="border px-4 py-2 capitalize whitespace-nowrap">{{ $inventario->tipo_movimiento }}
                                </td>
                                <td class="border px-4 py-2 whitespace-nowrap">{{ number_format($inventario->stock) }}</td>
                                <td class="border px-4 py-2 whitespace-nowrap">{{ $inventario->created_at->format('d/m/Y') }}
                                </td>
                                <td class="border px-4 py-2">
                                    <div class="flex flex-wrap gap-2">
                                        @can('inventario.edit')
                                            <a href="{{ route('inventario.edit', $inventario->id) }}"
                                                class="text-blue-500 hover:text-blue-600  text-xs  py-1 rounded"><ion-icon
                                                    name="create-outline" class="h-6 w-6"></ion-icon></a>
                                        @endcan
                                        @can('inventario.delete')
                                            <form action="{{ route('inventario.destroy', $inventario->id) }}"
                                                method="POST">
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
            </div>
        </div>
        <div class="mt-4">
            {{ $inventarios->links() }}
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div id="modal-reporte"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-lg font-bold mb-4 text-center">Generar Reporte de Inventario</h2>
            <form action="{{ route('inventario.reporte.pdf') }}" method="GET" target="_blank">
                @csrf
                <div class="mb-4">
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Seleccione la fecha:</label>
                    <input type="date" id="fecha" name="fecha" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="document.getElementById('modal-reporte').classList.add('hidden')"
                        class=" px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                        Generar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
