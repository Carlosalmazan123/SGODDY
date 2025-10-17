<x-app-layout>
    
    <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
      <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">INVENTARIOS ELIMINADOS</h1>
    <div class="flex flex-col ">
        @if(session("mensaje"))
    <div id="mensaje" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session("mensaje") }}
    </div>
@endif
@if(session('error'))
<div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    {{ session('error') }}
</div>
@endif                      
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
           

            {{-- Botones superiores --}}
           <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
                                <a href="{{ route('eliminado.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-back-outline" class="text-lg mr-2"></ion-icon> Volver
                                </a>
                                <form action="{{ route('inventario.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los inventarios eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>

                                <a href="{{ route('inventario.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon> Ir a
                                    Inventario
                                </a>
                            </div>

            {{-- Tabla responsiva --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 border">ID</th>
                                <th class="px-4 py-3 border">Producto</th>
                                <th class="px-4 py-3 border">Cantidad</th>
                                <th class="px-4 py-3 border">Eliminado el</th>
                                <th class="px-4 py-3 border text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deletedInventarios as $inventario)
                                <tr class="text-center border-t hover:bg-gray-50 transition-all">
                                    <td class="px-4 py-2">{{ $inventario->id }}</td>
                                    <td class="px-4 py-2">{{ $inventario->producto->nombre }}</td>
                                    <td class="px-4 py-2">{{ $inventario->stock }}</td>
                                    <td class="px-4 py-2 text-gray-500">
                                        {{ $inventario->deleted_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-center space-x-2">
                                            <form action="{{ route('inventario.restore', $inventario->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                    Restaurar
                                                </button>
                                            </form>    
                                            <form action="{{ route('inventario.forceDelete', $inventario->id) }}" method="POST"
                                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente este inventario? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="rounded-lg text-center border-gray-500 px-4 py-2 text-gray-500"><ion-icon name="alert-circle-outline" class="text-gray-400 text-2xl"></ion-icon>No hay inventarios eliminados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $deletedInventarios->links() }}
                </div>
            </div>      
        </div> 
    </div>
    </div>
    </div>
    </div>
    </div>  
</x-app-layout>