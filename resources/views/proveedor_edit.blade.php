<x-app-layout>
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Editar Proveedor</h1>

    <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="w-full px-4 py-2 border rounded-md" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Contacto</label>
            <input type="text" name="contacto" value="{{ $proveedor->contacto }}" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Teléfono</label>
            <input type="text" name="telefono" value="{{ $proveedor->telefono }}" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ $proveedor->email }}" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Dirección</label>
            <textarea name="direccion" class="w-full px-4 py-2 border rounded-md">{{ $proveedor->direccion }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">Actualizar</button>
        <a href="{{ route('proveedores.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">Cancelar</a>
    </form>
</div>
</x-app-layout>