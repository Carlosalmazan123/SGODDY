<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Lista de Proveedores</h1>
    
        <a href="{{ route('proveedores.create') }}" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded">Agregar Proveedor</a>
    
        @if (session('success'))
        <div id="success-message" class="mt-3 p-2 bg-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    
        <script>
            // Desaparecer el mensaje después de 1 segundo
            setTimeout(function() {
                let message = document.getElementById('success-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 1000); // 1000 ms = 1 segundo
        </script>
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
                                @can("proveedor.edit")
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class=" py-1 text-blue-500  rounded" ><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                @endcan
                                @can("proveedor.delete")
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" py-1 text-red-500 rounded" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')"><ion-icon name="trash-outline" class="h-6 w-6"></ion-icon></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $proveedores->links() }}
            </div>
        </div>
    </div>    
</x-app-layout>