<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Editar Propietario</h1>
        
        <form action="{{ route('propietarios.update', $propietario) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto indica que el formulario es de tipo PUT para actualización -->
    
            <div class="mb-3">
                <label class="block font-medium">Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $propietario->nombre) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Apellido:</label>
                <input type="text" name="apellido" value="{{ old('apellido', $propietario->apellido) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Teléfono:</label>
                <input type="text" name="telefono" value="{{ old('telefono', $propietario->telefono) }}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
            </div>
    
            <div class="mb-3">
                <label class="block font-medium">Dirección:</label>
                <textarea name="direccion" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">{{ old('direccion', $propietario->direccion) }}</textarea>
            </div>
    
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Actualizar</button>
            <a href="{{ route('propietarios.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
        </form>
    </div>
    </x-app-layout>
    