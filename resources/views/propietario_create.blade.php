<x-app-layout>
<div class="container mx-auto p-4 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Registrar Propietario</h1>
      @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    <form action="{{ route('propietarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block font-medium">Nombre<b class="text-red-600">*</b>:</label>
            <input type="text" name="nombre" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" placeholder="Ej:Pedro" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Apellido<b class="text-red-600">*</b>:</label>
            <input type="text" name="apellido" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" placeholder="Ej:Perez" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Teléfono<b class="text-red-600">*</b>: </label>
            <input type="number" name="telefono" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" value="591" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium">CI<b class="text-red-600">*</b>:</label>
            <input type="text" name="ci" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" placeholder="Ej:1234567" required>
        </div>
        <div class="mb-3">
            <label class="block font-medium">Dirección:</label>
            <textarea name="direccion" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" placeholder="Opcional"></textarea>
        </div>
            <div class="mb-3">
            <label class="block font-medium">Correo electrónico<b class="text-red-600">*</b>:</label>
            <input type="text" name="correo" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" placeholder="Ej:pedro@gmail.com" required>
        </div>
 <!-- Checkbox de consentimiento
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="opt_in_whatsapp" id="opt_in_whatsapp" class="form-checkbox h-5 w-5 text-green-600" value="1">
            <span class="ml-2 text-gray-700">Acepto recibir mensajes de recordatorios y notificaciones por WhatsApp.</span>
        </label>
    </div>
     -->
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Guardar</button>
        <a href="{{ route('propietarios.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
    </form>
</div>
</x-app-layout>