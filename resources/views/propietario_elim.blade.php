<x-app-layout>
        <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
      <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">PROPIETARIOS ELIMINADOS</h1>
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
                                <form action="{{ route('propietarios.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los propietarios eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>
                                <a href="{{ route('propietarios.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon>
                                    Ir a Propietarios
                                </a>

                            </div>

            {{-- Tabla responsiva --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                
            <div class="overflow-x-auto overflow-hidden">
                <table class="w-full mt-4 border-collapse border ">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 border">ID</th>
                                <th class="px-4 py-3 border">Nombre</th>
                                <th class="px-4 py-3 border">Apellido</th>
                                <th class="px-4 py-3 border">Teléfono</th>
                                <th class="px-4 py-3 border">Correo</th>
                                <th class="px-4 py-3 border">Eliminado el</th>
                                <th class="px-4 py-3 border text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deletedPropietarios as $propietario)
                                <tr class="text-center border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ $propietario->id }}</td>
                                    <td class="px-4 py-2">{{ $propietario->nombre }}</td>
                                    <td class="px-4 py-2">{{ $propietario->apellido }}</td>
                                    <td class="px-4 py-2">{{ $propietario->telefono }}</td>
                                    <td class="px-4 py-2">{{ $propietario->email }}</td>
                                    <td class="px-4 py-2 text-gray-500">{{ $propietario->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 flex justify-center space-x-2">
                                        {{-- Botón restaurar --}}
                                        <form action="{{ route('propietarios.restore', $propietario->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                                <ion-icon name="refresh-outline" class="mr-1 text-lg"></ion-icon>
                                                Restaurar
                                            </button>
                                        </form>

                                        {{-- Botón eliminar definitivo --}}
                                        <form action="{{ route('propietarios.forceDelete', $propietario->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar permanentemente este propietario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                                <ion-icon name="trash-outline" class="mr-1 text-lg"></ion-icon>
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">
                                        <ion-icon name="alert-circle-outline" class="text-gray-400 text-2xl"></ion-icon>
                                        No hay propietarios eliminados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $deletedPropietarios->links() }}
            </div>
        </div>
    </div>
</div>
        </div>
    </div>

</x-app-layout>
