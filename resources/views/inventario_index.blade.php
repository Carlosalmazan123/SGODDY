<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-4">Movimientos de Inventario</h1>
        
        <a href="{{ route('inventario.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mb-4 inline-block">Registrar Movimiento</a>
    
        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
    
        <table class="min-w-full table-auto bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Producto</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Cantidad</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Tipo Movimiento</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Descripción</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Fecha</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $inventario)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $inventario->producto->nombre }}</td>
                        <td class="px-4 py-2">{{ $inventario->cantidad }}</td>
                        <td class="px-4 py-2 capitalize">{{ $inventario->tipo_movimiento }}</td>
                        <td class="px-4 py-2">{{ $inventario->descripcion }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('inventario.edit', $inventario->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Editar</a>
                            <form action="{{ route('inventario.destroy', $inventario->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>