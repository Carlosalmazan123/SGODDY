<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Servicios</h1>
        <a href="{{ route('servicios.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Crear Servicio</a>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-300 shadow-md">
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
                            <td class="border border-gray-300 px-4 py-2 flex gap-2">
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md">Editar</a>
                                <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
