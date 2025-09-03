<x-app-layout>
<div class="container mx-auto p-4 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Registrar Propietario</h1>
    
    <form action="{{ route('propietarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block font-medium">Nombre:</label>
            <input type="text" name="nombre" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Apellido:</label>
            <input type="text" name="apellido" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Teléfono:</label>
            <input type="text" name="telefono" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Dirección:</label>
            <textarea name="direccion" class="w-full p-2 border rounded focus:ring focus:ring-blue-300"></textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Guardar</button>
        <a href="{{ route('propietarios.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
    </form>
</div>
</x-app-layout>