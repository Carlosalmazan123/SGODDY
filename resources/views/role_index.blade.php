<x-app-layout>
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
       


    <div class="py-5 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white  overflow-hidden  sm:rounded-lg shadow-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-800">


    <div class="container mx-auto p-4 ">
        <h1 class="text-2xl font-bold mb-4">ROLES</h1>
    <div class="flex flex-col text-center">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5  ">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8 ">
            <div class="overflow-hidden">
              <table class="min-w-full  ">
                <thead class="bg-gray-400  ">
                            <tr>
                                <th  class="border border-gray-500 px-4 py-2 text-black">Nombre</th>
                                <th  class="border border-gray-500 px-4 py-2 text-black">
                                    <a href="{{ route("roles.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($roles as $role)
                                <tr>
                                    <td  class="border border-gray-500 px-4 py-2 text-start text-black ">{{ $role->name }}</td>
                                    <td  class="border border-gray-500 px-4 py-2 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route("roles.permissions.edit", [$role]) }}" class="text-green-600 hover:text-green-700 font-bold py-2  rounded" title="Permisos"><ion-icon name="shield-checkmark-outline" class="h-6 w-6"></ion-icon>
                                            </a>
                                            <a href="{{ route("roles.edit", [$role]) }}" class="text-blue-500 hover:text-orange-600 font-bold py-2 rounded" title="Editar"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                            </a>
                                            <button type="button" class="text-red-500 hover:text-red-700  font-bold py-1.5 rounded"  onclick="toggleModal('deleteModal{{$role->id}}')" title ="Eliminar">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>

                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div id="deleteModal{{$role->id}}" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="bg-red-500 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                                            Confirmar Eliminación
                                                        </h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-white">
                                                                ¿Desea eliminar el registro seleccionado? Esta acción no puede deshacerse.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <form action="{{route("roles.destroy", [$role])}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Eliminar
                                                    </button>
                                                </form>
                                                <button onclick="toggleModal('deleteModal{{$role->id}}')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
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



