<x-app-layout>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Editar Cita</h1>
    <form action="{{ route('citas.update', $cita->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="paciente_id" class="block text-sm font-medium text-gray-700">Paciente</label>
            <select name="paciente_id" id="paciente_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
                        {{ $paciente->nombre }} {{ $paciente->apellido }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="fecha_hora" class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ $cita->fecha_hora }}" required>
        </div>

        <div class="mb-4">
            <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo</label>
            <input type="text" name="motivo" id="motivo" class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ $cita->motivo }}" required>
        </div>

        <div class="mb-4">
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" id="estado" class="w-full border-gray-300 rounded-lg shadow-sm">
                <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Confirmada" {{ $cita->estado == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="Cancelada" {{ $cita->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="flex justify-between">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
            <a href="{{ route('citas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancelar</a>
        </div>
    </form>
</div>
</x-app-layout>