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
        <div class="w-100 flex items-end justify-end" class="mx-9">
<div>
    <form action="{{route("roles.index")}}" method="GET"  >
        <div >
            <button type="submit" value="enviar"  class="text-white mt-2  right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Regresar</button>


        </div>


    </form>
</div>

	<form action="{{route("roles.index")}}" method="GET">
        <label for="default-search" class="mb-2  absolute text-sm font-medium text-gray-900 sr-only :text-gray-300">Search</label>
        <div class="relative">

            <div>
              <input type="search" name="busqueda" value="{{$busqueda}}" class="block p-4 pr-20 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500" placeholder="Buscar" required>
              <button type="submit" value="enviar"  class="text-white absolute right-1 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-2 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800"><svg class="w-5 h-5 text-white :text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>

            </div>
                       </div>
    </form>
        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</div>


    <div class="py-5 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg shadow-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">


    <div class="container mx-auto p-4 ">
        <h1 class="text-2xl font-bold mb-4">ROLES</h1>
    <div class="flex flex-col text-center">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5  ">
          <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8 ">
            <div class="overflow-hidden">
              <table class="min-w-full  ">
                <thead class="bg-orange-500  ">
                            <tr>
                                <th  class="border border-gray-500 px-4 py-2 text-white">Nombre</th>
                                <th  class="border border-gray-500 px-4 py-2 text-white">
                                    <a href="{{ route("roles.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($roles as $role)
                                <tr>
                                    <td  class="border border-gray-500 px-4 py-2 text-start">{{ $role->name }}</td>
                                    <td  class="border border-gray-500 px-4 py-2 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route("roles.permissions.edit", [$role]) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Permisos</a>
                                            <a href="{{ route("roles.edit", [$role]) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">Editar</a>
                                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1.5 px-4 rounded"  onclick="toggleModal('deleteModal{{$role->id}}')">
                                                Eliminar
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



