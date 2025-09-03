<x-app-layout>

    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Editar Categoría</h1>
    
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="{{ old('nombre', $categoria->nombre) }}" required>
                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="mt-1 p-2 w-full border border-gray-300 rounded-md">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>
    
            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Actualizar Categoría</button>
                <a href="{{ route('categorias.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Cancelar</a>
            </div>
        </form>
    </div>
    
    </x-app-layout>
    