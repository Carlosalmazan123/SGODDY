<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Editar Propietario</h1>
        @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
        <form action="{{ route('propietarios.update', $propietario) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto indica que el formulario es de tipo PUT para actualización -->
    
            <div class="mb-3">
                <label class="block font-medium">Nombre<b class="text-red-600">*</b>:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $propietario->nombre) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Apellido<b class="text-red-600">*</b>:</label>
                <input type="text" name="apellido" value="{{ old('apellido', $propietario->apellido) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Teléfono<b class="text-red-600">*</b>:</label>
                <input type="text" name="telefono" value="{{ old('telefono', $propietario->telefono) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-3">
                <label class="block font-medium">CI<b class="text-red-600">*</b>:</label>
                <input type="text" name="ci" value="{{ old('ci', $propietario->ci) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Dirección:</label>
                <textarea name="direccion" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">{{ old('direccion', $propietario->direccion) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="block font-medium">Correo electrónico<b class="text-red-600">*</b>:</label>
                <input type="text" name="correo" value="{{ old('correo', $propietario->correo) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Actualizar</button>
            <a href="{{ route('propietarios.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
        </form>
    </div>
    </x-app-layout>
    