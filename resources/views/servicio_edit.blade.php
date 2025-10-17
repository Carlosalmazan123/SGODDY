<x-app-layout>
    @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    @php
    // Convertir duración HH:MM:SS a minutos
    list($h, $m, $s) = explode(':', $servicio->duracion);
    $duracionMinutos = ($h * 60) + $m;
@endphp
    <div class="max-w-3xl mx-auto container bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4 text-gray-700">Editar Servicio</h1>

        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-gray-700 font-medium">Nombre*</label>
                <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('nombre', $servicio->nombre) }}" required>
            </div>

            <div>
                <label for="descripcion" class="block text-gray-700 font-medium">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $servicio->descripcion) }}</textarea>
            </div>

            <div>
                <label for="precio" class="block text-gray-700 font-medium">Precio*</label>
                <input type="number" name="precio" id="precio" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('precio', $servicio->precio) }}" step="0.01" required>
            </div>

            <div>
                <label for="duracion" class="block text-gray-700 font-medium">Duración en minutos*</label>
                <input class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" type="number" name="duracion" id="duracion" value="{{ old('duracion', $duracionMinutos) }}" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="activo" id="activo" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ $servicio->activo ? 'checked' : '' }}>
                <label for="activo" class="ml-2 text-gray-700 font-medium">Activo*</label>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Actualizar</button>
        </form>
    </div>
</x-app-layout>
