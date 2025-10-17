<x-app-layout>
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Registrar Proveedor</h1>
@if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" class="w-full px-4 py-2 border rounded-md" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Contacto</label>
            <input type="text" name="contacto" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Teléfono</label>
            <input type="text" name="telefono" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Dirección</label>
            <textarea name="direccion" class="w-full px-4 py-2 border rounded-md"></textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Guardar</button>
    </form>
</div>
</x-app-layout>