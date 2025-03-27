
<x-app-layout >
    
        
          
        <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4" >
            <h2 class="text-2xl font-bold mb-4">Gestión de Citas</h2>
            
            <a href="{{ route('citas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Agendar Cita</a>
            @if (session('success'))
            <div class="mt-3 p-3 bg-green-200 text-green-700 rounded">{{ session('success') }}</div>
        @endif
            <div  class="overflow-x-auto overflow-hidden ">
            <table class="w-full mt-4 border-collapse border  ">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Paciente</th>
                        <th class="border p-2">Dueño del paciente</th>
                        <th class="border p-2">Fecha de la cita</th>
                        <th class="border p-2">Hora de la cita</th>
                        <th class="border p-2">Estado</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                    <tr class="border">
                        <td class="p-2">{{ $cita->relPaciente->nombre }}</td>
                        <td class="p-2">{{ $cita->relPaciente->relPropietario->nombre }}</td>
                        <td class="p-2">{{ $cita->fecha_cita }}</td>
                        <td class="p-2">{{ $cita->hora_cita }}</td>
                        <td class="p-2">{{ $cita->estado }}</td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('citas.show', $cita->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Ver
                                </a>
                                <a href="{{ route('citas.edit', $cita) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Editar
                                </a>
                                <form action="{{ route('citas.destroy', $cita) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
</x-app-layout>
