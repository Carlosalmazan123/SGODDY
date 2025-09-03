<x-app-layout>
<div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4 ">
    <h1 class="text-2xl font-bold mb-4">Lista de Propietarios</h1>
    <a href="{{ route('propietarios.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Nuevo Propietario</a>

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

    <div class="overflow-x-auto overflow-hidden">
        <table class="w-full mt-4 border-collapse border ">
            <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Apellido</th>
                    <th class="p-2">Teléfono</th>
                    
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($propietarios as $propietario)
                <tr class="border-t">
                    <td class="p-2">{{ $propietario->nombre }}</td>
                    <td class="p-2">{{ $propietario->apellido }}</td>
                    <td class="p-2">{{ $propietario->telefono }}</td>
             
                    <td class="p-2">
                        <div class="flex items-center gap-2">
                        <!-- Botón para abrir el modal -->
<div x-data="{ openModal: false }">

    <button
        @click="openModal = true"
        class="text-green-500 hover:text-green-700"
        title="Ver Propietario"
    >
        <ion-icon name="eye-outline" class="h-6 w-6"></ion-icon>
    </button>

    <!-- Modal -->
    <div
        x-show="openModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-6 rounded-xl shadow-xl w-11/12 sm:w-2/3 lg:w-1/3 relative">
            <!-- Botón de cierre -->
            <button
                @click="openModal = false"
                class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white text-2xl"
            >
                &times;
            </button>

            <!-- Título -->
            <h2 class="text-xl font-bold mb-4">Detalles del Propietario</h2>

            <!-- Contenido -->
            <div class="space-y-3">
                <p><strong>👤 Nombre:</strong> {{ $propietario->nombre }} {{ $propietario->apellido }}</p>
                <p><strong>📞 Teléfono:</strong> {{ $propietario->telefono }}</p>
                <p><strong>🏠 Dirección:</strong> {{ $propietario->direccion ?? 'No especificada' }}</p>
                <p><strong>🐾 Mascotas:</strong></p>
               <ul class="list-disc list-inside text-gray-800 dark:text-white bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm space-y-2">
    @forelse ($propietario->relPaciente as $paciente)
        <li class="flex items-center justify-between">
            <span class="pl-1">{{ $paciente->nombre }}</span>
            <a href="{{ route('pacientes.show', $paciente) }}"
               class="text-green-500 hover:text-green-600 transition">
                <ion-icon class="w-5 h-5" name="eye-outline"></ion-icon>
            </a>
        </li>
    @empty
        <li class="text-red-500 font-semibold">No tiene mascotas registradas.</li>
    @endforelse
</ul>

            </div>

            <!-- Botón de cerrar -->
            <div class="mt-6 text-right">
                <button
                    @click="openModal = false"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded"
                >
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@can("propietario.edit")
                        <a href="{{ route('propietarios.edit', $propietario) }}" class=" py-1 text-blue-500  rounded hover:text-blue-600" ><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                        @endcan
                        @can("propietario.delete")
                        <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="py-1 text-red-500  rounded hover:text-red-600"><ion-icon name="trash-outline" class="h-6 w-6"></ion-icon></button>
                        </form>
                        @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $propietarios->links() }}
        </div>
    </div>
</div>
</x-app-layout>
