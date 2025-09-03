<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4 ">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Servicios</h1>
        <a href="{{ route('servicios.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Crear Servicio</a>
        
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
        <table class="w-full mt-4 border-collapse border bg-gray-300  ">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2">Descripción</th>
                        <th class="border border-gray-300 px-4 py-2">Precio</th>
                        <th class="border border-gray-300 px-4 py-2">Duración</th>
                        <th class="border border-gray-300 px-4 py-2">Estado</th>
                        <th class="border border-gray-300 px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2">{{ $servicio->nombre }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $servicio->descripcion }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($servicio->precio, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $servicio->duracion }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <span class="px-2 py-1 text-sm font-semibold rounded-md {{ $servicio->activo ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class=" px-4 py-2 flex gap-2">
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="text-blue-500 hover:text-blue-600  py-1 rounded-md"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 py-1 rounded-md"><ion-icon name="trash-outline" class="h-6 w-6"></ion-icon></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $servicios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
