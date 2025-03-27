<x-app-layout>
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Categorías</h2>
    <a href="{{ route('categorias.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Categoría</a>
    <table class="w-full mt-4 border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Nombre</th>
                <th class="p-2 border">Descripción</th>
                <th class="p-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td class="p-2 border">{{ $categoria->nombre }}</td>
                    <td class="p-2 border">{{ $categoria->descripcion }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('categorias.edit', $categoria) }}" class="text-blue-500">Editar</a>
                        <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
