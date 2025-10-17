<x-app-layout>
    <!-- Table Content -->
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4  ">
        <h1 class="text-2xl font-bold mb-4">Mascotas</h1>
        <a href="{{ route('pacientes.create') }}" class="px-5 py-1  bg-blue-500  text-white text-end rounded mb-1 inline-block">
            <div class="text-center">
     
              + Agregar Paciente
            </div>
        </a>
        <br>
        <a href="{{ route('pacientes.reporte.pdf') }}" target="_blank" class="text-white bg-green-500 hover:bg-green-600 px-2 py-1 rounded inline-flex items-center ">
            <ion-icon name="document-text-outline" class="mr-2 text-xl"></ion-icon>
            Generar Reporte
        </a>
        
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
                    <tr >
                        <th class="border px-4 py-2 text-left">Nombre</th>
                        <th class="border px-4 py-2 text-left">Especie</th>
                        <th class="border px-4 py-2 text-left">Edad</th>
                        <th class="border px-4 py-2 text-left">Imagen</th>
                        <th class="border px-4 py-2 text-left">Propietario</th>
                        <th class="border px-4 py-2 text-left">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr class="border">
                        <td class="border px-4 py-2">{{ $paciente->nombre }}</td>
                        <td class="border px-4 py-2">{{ $paciente->especie }}</td>
                        <td class="border px-4 py-2">{{ $paciente->edad }}</td>
                        <td class="border px-4 py-2 border-b">
                            @if ($paciente->imagen)
                                <img src="{{ asset('storage/'.$paciente->imagen) }}" alt="Imagen del paciente" class="w-16 h-16 object-cover rounded-md">
                            @else
                                <span class="text-gray-500">No tiene imagen</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $paciente->relPropietario->nombre ?? "Sin" }} {{ $paciente->relPropietario->apellido ?? "propietario" }}</td>
                        <td class="border px-4 py-2">
                            @can("paciente.edit")
                            <a href="{{ route('pacientes.show', $paciente) }}" class="text-green-500">
                                <ion-icon class="h-6 w-6" name="eye-outline"></ion-icon>
                            </a>
                            @endcan
                            @can("paciente.edit")
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="text-blue-500"><ion-icon class="h-6 w-6" name="create-outline"></ion-icon></a>
                            @endcan
                            @can("paciente.delete")
                            <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?');" class="text-red-500"><ion-icon name="trash-outline" class=" h-6 w-6"></ion-icon></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
          </div>
            <div class="mt-4">
                {{ $pacientes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
