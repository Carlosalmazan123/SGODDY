<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Lista de Proveedores</h1>
    
        <a href="{{ route('proveedores.create') }}" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded">Agregar Proveedor</a>
    
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mt-2">
                {{ session('success') }}
            </div>
        @endif
    
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Contacto</th>
                        <th class="border px-4 py-2">Teléfono</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Dirección</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td class="border px-4 py-2">{{ $proveedor->nombre }}</td>
                            <td class="border px-4 py-2">{{ $proveedor->contacto }}</td>
                            <td class="border px-4 py-2">{{ $proveedor->telefono }}</td>
                            <td class="border px-4 py-2">{{ $proveedor->email }}</td>
                            <td class="border px-4 py-2">{{ $proveedor->direccion }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Editar</a>
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
</x-app-layout>