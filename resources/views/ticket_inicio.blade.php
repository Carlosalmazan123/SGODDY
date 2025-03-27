<x-app-layout>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Listado de Tickets Virtuales</h1>
    
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Cliente</th>
                    <th class="border border-gray-300 px-4 py-2">Nombre de la mascota</th>
                    <th class="border border-gray-300 px-4 py-2">Tipo del servicio</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha</th>
                    <th class="border border-gray-300 px-4 py-2">Hora</th>
                    
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = $tickets->count(); @endphp
                @foreach ($tickets as $ticket)
                <tr class="text-center {{ $ticket->estado == 'Atendido' ? 'bg-green-100' : 'bg-red-100' }}">
                    <td class="border border-gray-300 px-4 py-2">{{ $contador }}</td> <!-- Contador descendente -->
                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->user->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->nombre_mascota }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->servicio->nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->fecha_cita }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->hora_cita }}</td>
                    
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">Ver</a>
                    
                        | <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-yellow-500 hover:underline">Editar</a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @php $contador--; @endphp
                @endforeach
            </tbody>
            
        </table>
    </div>
</div>
</x-app-layout>