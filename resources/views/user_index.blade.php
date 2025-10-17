

<x-app-layout>
    
    <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
    <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">USUARIOS</h1>
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

<div class="bg-white mt-3 shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr>
                <th scope="col" class=" border px-4 py-2 text-black">
                ID
                </th>
              <th scope="col" class=" border px-4 py-2 text-black">
                Nombre
              </th>
              <th scope="col" class=" border px-4 py-2 text-black">
                Correo
              </th>
              <th scope="col" class=" border px-4 py-2 text-black">
                Contraseña
              </th>
              <th scope="col" class=" border px-4 py-2 text-black">
                <button clas="bg-gray-500">
                    <a href="{{ route("users.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</a>
                </button>

              </th>
            </tr>
          </thead >
          <tbody class="bg-white text-center text-black">
            @if (count($users)<=0)
                <tr>
                    <td>
                        No se encontró el usuario
                    </td>
                </tr>

            @else
             @foreach($users as $user)
                            <tr >
                                <td class="  border px-4 py-2 text-start">{{$user->id}}</td>
                                <td class="  border px-4 py-2 text-start">{{$user->name}}</td>
                                <td class="  border px-4 py-2">{{$user->email}}</td>
                                <td class="  border px-4 py-2">*****</td>
                                @can("user.edit")
                                        <td class="  border px-4 py-2 text-center space-x-2">
                                            <a href="{{ route('users.roles.edit', $user) }}" class="inline-flex items-center justify-center text-green-600 hover:text-green-700 rounded" title="Roles">
                                                <ion-icon name="shield-checkmark-outline" class="w-5 h-5"></ion-icon>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center text-blue-500 hover:text-yellow-600   rounded" title="Editar">
                                                <ion-icon name="create-outline" class="w-6 h-6"></ion-icon>
                                            </a>
                                            @can("user.delete")
                                            <form action="{{ route('users.destroy', [$user]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-600 text-xs  py-1 rounded"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminarlo?')">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                        </button>
                                            </form>
                                            @endcan
                                        </td>
                                        @endcan
                            </tr>
                            
                        @endforeach
                        @endif
          </tbody>
        </table>
        </div>
            </div>
        {{ $users->links() }}
    
  </div>
</div>
    </div>
                </div>
            </div>
      

</x-app-layout>
<script>
    function toggleModal(modalId) {
   const modal = document.getElementById(modalId);
   modal.classList.toggle('hidden');
}
   setTimeout(function() {
   var mensaje = document.getElementById('mensaje');
   if (mensaje) {
       mensaje.style.display = 'none';
   }
   var error = document.getElementById('error');
   if (error) {
       error.style.display = 'none';
   }
}, 500);
</script>
