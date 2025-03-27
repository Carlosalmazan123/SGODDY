<x-app-layout>
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md mt-4">
    <h1 class="text-2xl font-bold mb-4">Detalles de la Cita</h1>

    <div class="mb-4">
        <p><strong>Paciente:</strong> {{ $cita->relPaciente->nombre }}</p>
        <p><strong>Fecha y Hora:</strong> {{ $cita->fecha_hora }}</p>
        <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>
        <p><strong>Estado:</strong> 
            <span class="px-2 py-1 rounded-lg text-white 
                {{ $cita->estado == 'Pendiente' ? 'bg-yellow-500' : ($cita->estado == 'Confirmada' ? 'bg-green-500' : 'bg-red-500') }}">
                {{ $cita->estado }}
            </span>
        </p>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('citas.edit', $cita->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Editar</a>
        <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta cita?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Eliminar</button>
        </form>
        <a href="{{ route('citas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Volver</a>
    </div>
</div>
</x-app-layout>