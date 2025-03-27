<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-xl shadow mt-4">
        <h1 class="text-3xl font-bold mb-4">Historial Clínico</h1>

        <a href="{{ route('historial.create') }}" class="px-4 py-2 bg-green-600 text-white rounded shadow-md hover:bg-green-700">Agregar Nuevo</a>

        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Paciente</th>
                    <th class="border p-2">Descripción</th>
                    <th class="border p-2">Fecha</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiales as $historial)
                    <tr class="border">
                        <td class="border p-2">{{ $historial->paciente->nombre }}</td>
                        <td class="border p-2">{{ Str::limit($historial->descripcion, 50) }}</td>
                        <td class="border p-2">{{ $historial->fecha }}</td>
                        <td class="border p-2">
                            <a href="{{ route('historial.show', $historial) }}" class="px-2 py-1 bg-blue-500 text-white rounded">Ver</a>
                            <a href="{{ route('historial.edit', $historial) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Editar</a>
                            <form action="{{ route('historial.destroy', $historial) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded" onclick="return confirm('¿Seguro que deseas eliminar este historial?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
