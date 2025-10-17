<x-app-layout>
   
        <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
      <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">PROVEEDORES ELIMINADOS</h1>
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
               <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
                                <a href="{{ route('eliminado.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-back-outline" class=" text-lg mr-2"></ion-icon> Volver
                                </a>
                                <form action="{{ route('proveedores.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los proveedores eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>
                                <a href="{{ route('proveedores.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon>
                                    Ir a Proveedores
                                </a>

                            </div>
                {{-- Tabla responsiva --}}
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 border">ID</th>
                                    <th class="px-4 py-3 border">Nombre</th>
                                    <th class="px-4 py-3 border">Teléfono</th>
                                    <th class="px-4 py-3 border">Correo</th>
                                    <th class="px-4 py-3 border">Eliminado el</th>
                                    <th class="px-4 py-3 border text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedProveedores as $proveedor)
                                    <tr class="text-center border-t hover:bg-gray-50 transition-all">
                                        <td class="px-4 py-2">{{ $proveedor->id }}</td>
                                        <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                                        <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                                        <td class="px-4 py-2">{{ $proveedor->email }}</td>
                                        <td class="px-4 py-2">{{ $proveedor->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2 flex justify-center gap-2">
                                            <!-- Restaurar -->
                                            <form action="{{ route('proveedores.restore', $proveedor->id) }}" method="POST">
                                                @csrf
                                              
                                                <button type="submit"
                                                        class="flex items-center gap-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-all duration-200">
                                                    <ion-icon name="refresh-outline" class="w-5 h-5"></ion-icon>
                                                    Restaurar
                                                </button>
                                            </form>
    
                                            <!-- Eliminar permanentemente -->
                                            <form action="{{ route('proveedores.forceDelete', $proveedor->id) }}" method="POST"
                                                    onsubmit="return confirm('¿Eliminar permanentemente este proveedor?')"> 
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="flex items-center gap-2 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition-all duration-200">
                                                    <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                            No hay proveedores eliminados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                   {{-- Paginación --}}
            <div class="mt-4">
                {{ $deletedProveedores->links() }}
            </div>
          </div>
      </div>
      </div>
      </div>
      </div>
      </div>
</x-app-layout>