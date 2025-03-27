<x-app-layout>
<div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4 ">
    <h1 class="text-2xl font-bold mb-4">Lista de Propietarios</h1>
    <a href="{{ route('propietarios.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Nuevo Propietario</a>

    @if (session('success'))
        <div class="mt-3 p-3 bg-green-200 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto overflow-hidden">
        <table class="w-full mt-4 border-collapse border ">
            <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Apellido</th>
                    <th class="p-2">Teléfono</th>
                    
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($propietarios as $propietario)
                <tr class="border-t">
                    <td class="p-2">{{ $propietario->nombre }}</td>
                    <td class="p-2">{{ $propietario->apellido }}</td>
                    <td class="p-2">{{ $propietario->telefono }}</td>
             
                    <td class="p-2 flex space-x-2">
                        <a href="{{ route('propietarios.edit', $propietario) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                        <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
