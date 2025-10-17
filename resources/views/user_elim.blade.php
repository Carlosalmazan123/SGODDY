<x-app-layout>
       <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
      <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">USUARIOS ELIMINADOS</h1>
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
         <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
                                <a href="{{ route('eliminado.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-back-outline" class=" text-lg mr-2"></ion-icon> Volver
                                </a>
                                <form action="{{ route('users.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los usuarios eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>
                                <a href="{{ route('users.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon>
                                    Ir a Usuarios
                                </a>

                            </div>

            <div class="bg-white mt-3 shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr >
                            <th scope="col" class="border  px-4 py-2 text-black">ID</th>
                            <th scope="col" class="border  px-4 py-2 text-black">Nombre</th>
                            <th scope="col" class="border  px-4 py-2 text-black">Correo</th>
                            <th scope="col" class="border  px-4 py-2 text-black">Eliminado el</th>
                            <th scope="col" class="border  px-4 py-2 text-black text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-center text-black">
                        @forelse ($users as $user)
                            <tr>
                                
                                <td class="border  px-4 py-2 text-start">{{ $user->id }}</td>
                                <td class="border  px-4 py-2 text-start">{{ $user->name }}</td>
                                <td class="border  px-4 py-2">{{ $user->email }}</td>
                                <td class="border  px-4 py-2 text-gray-500">
                                    {{ $user->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class=" border  py-4 text-center space-x-2">
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                            Restaurar
                                        </button>
                                    </form>

                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 transition"
                                        onclick="return confirm('¿Estás seguro? Ya no se podrá recuperar este usuario.')">
                                            Borrar definitivo
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border  px-4 py-2 text-gray-500"><ion-icon name="alert-circle-outline" class="text-gray-400 text-2xl"></ion-icon>No hay usuarios eliminados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
                {{-- Paginación --}}
                <div class="mt-4">
                    {{ $users->links() }}
</div>
                </div>
       </div>   
       
</x-app-layout>
