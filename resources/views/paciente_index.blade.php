<x-app-layout>
    <!-- Table Content -->
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4  ">
        <h1 class="text-2xl font-bold mb-4">Mascotas</h1>
        <a href="{{ route('pacientes.create') }}" class="px-5 py-1  bg-blue-500  text-white text-end rounded mb-4 inline-block">
            <div class="text-center">
     
              + Agregar Paciente
            </div>
            
        </a>
        
       
          <div class="overflow-x-auto overflow-hidden ">
            <table class="w-full mt-4 border-collapse border  ">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">Nombre</th>
                        <th class="border p-2 text-left">Especie</th>
                        <th class="border p-2 text-left">Edad</th>
                        <th class="border p-2 text-left">Imagen</th>
                        <th class="border p-2 text-left">Propietario</th>
                        <th class="border p-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr class="border">
                        <td class="p-2">{{ $paciente->nombre }}</td>
                        <td class="p-2">{{ $paciente->especie }}</td>
                        <td class="p-2">{{ $paciente->edad }}</td>
                        <td class="px-4 py-2 border-b">
                            @if ($paciente->imagen)
                                <img src="{{ asset('storage/'.$paciente->imagen) }}" alt="Imagen del paciente" class="w-16 h-16 object-cover rounded-md">
                            @else
                                <span class="text-gray-500">No tiene imagen</span>
                            @endif
                        </td>
                        <td class="p-2">{{ $paciente->relPropietario->nombre }} {{ $paciente->relPropietario->apellido }}</td>
                        <td class="p-2">
                            <a href="{{ route('pacientes.show', $paciente) }}" class="text-green-500">
                                <ion-icon class="h-6 w-6" name="eye"></ion-icon>
                            </a>
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="text-blue-500"><ion-icon class="h-8 w-8" name="create"></ion-icon></a>
                            <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500"><ion-icon name="trash" class=" h-8 w-8"></ion-icon></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
