<!-- resources/views/historial/index.blade.php -->
<x-app-layout>
    <div class="max-w-5xl mx-auto container bg-white p-4 sm:p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 flex items-center gap-2">
            <ion-icon name="document-text-outline" class="text-blue-600 text-xl sm:text-2xl"></ion-icon>
            Historiales de: {{ $paciente->nombre }}
        </h2>

        <!-- Datos del paciente -->
        <div class="mb-4 text-xs sm:text-sm text-gray-700 bg-gray-50 p-4 rounded-lg shadow-sm">
            <p><strong>Propietario:</strong> {{ $paciente->relPropietario->nombre ?? '-' }}
                {{ $paciente->relPropietario->apellido ?? '' }}</p>
            <p><strong>Especie:</strong> {{ $paciente->especie ?? '-' }} — <strong>Raza:</strong>
                {{ $paciente->raza ?? '-' }}</p>
        </div>

        @if ($historial->count())
            <!-- Crear nuevo historial -->
            <div class="flex justify-start mb-4">
                <a href="{{ route('historial.create', $paciente->id) }}"
                    class="px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition text-sm sm:text-base">
                    + Nuevo Historial Clínico
                </a>
            </div>

            <div class="bg-white mt-3 shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="border sm:px-4 py-2 sm:py-3">Fecha</th>
                                <th class="border sm:px-4 py-2 sm:py-3">Signos</th>
                                <th class="border sm:px-4 py-2 sm:py-3">Diagnóstico</th>
                                <th class="border sm:px-4 py-2 sm:py-3">Examen</th>
                                <th class="border sm:px-4 py-2 sm:py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historial as $h)
                                <tr class="odd:bg-gray-50  transition">
                                    <td class=" border sm:px-4 py-2">
                                        {{ optional($h->created_at)->format('d/m/Y') ?? '-' }}</td>
                                    <td class=" border sm:px-4 py-2">{{ $h->anamnesis ?? '-' }}</td>
                                    <td class=" border sm:px-4 py-2">{{ $h->diagnostico ?? '-' }}</td>
                                    <td class=" border sm:px-4 py-2">{{ $h->examen ?? '-' }}</td>
                                    <td class=" border sm:px-4 py-2 text-center">
                                        <div
                                            class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-3">
                                            <!-- Ver -->
                                            <button onclick="openModal('{{ route('historial.show', $h->id) }}')"
                                                class="flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs sm:text-sm">
                                                <ion-icon name="eye-outline" class="text-base sm:text-lg"></ion-icon>
                                                Ver
                                            </button>

                                            <!-- Editar -->
                                            <a href="{{ route('historial.edit', [$paciente->id, $h->id]) }}"
                                                class="flex items-center gap-1 text-green-600 hover:text-green-800 text-xs sm:text-sm">
                                                <ion-icon name="create-outline" class="text-base sm:text-lg"></ion-icon>
                                                Editar
                                            </a>

                                            <!-- PDF -->
                                            <a href="{{ route('historial.reporte', [$paciente->id, $h->id]) }}"
                                                target="_blank"
                                                class="flex items-center gap-1 text-red-600 hover:text-red-800 text-xs sm:text-sm">
                                                <ion-icon name="document-outline"
                                                    class="text-base sm:text-lg"></ion-icon> PDF
                                            </a>
                                            <!-- Eliminar -->
                                            <form action="{{ route('historial.destroy', [$paciente->id, $h->id]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Eliminar este historial clínico? Esta acción no se puede deshacer.')"
                                                    class="flex items-center gap-1 text-gray-600 hover:text-gray-800 text-xs sm:text-sm">
                                                    <ion-icon name="trash-outline"
                                                        class="text-base sm:text-lg"></ion-icon> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Paginación -->
            <div class="mt-4">
                {{ $historial->links() }}
            </div>
        @else
            <p class="text-gray-500 italic">No hay registros para este paciente.</p>
            <a href="{{ route('historial.create', $paciente->id) }}"
                class="inline-flex items-center gap-2 mt-3 px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base">
                <ion-icon name="add-circle-outline" class="text-lg sm:text-xl"></ion-icon> Crear historial
            </a>
        @endif
    </div>

    <!-- Modal responsivo -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg max-w-3xl w-full mx-4">
            <div class="overflow-y-auto max-h-80 p-2 border border-gray-200 rounded-md">

                <!-- Botón de cerrar arriba -->
                <button onclick="toggleModal()"
                    class="absolute top-3 right-3 text-gray-600 hover:text-black text-xl sm:text-2xl">
                    <ion-icon name="close-outline"></ion-icon>
                </button>

                <!-- Contenido del modal -->
                <div id="modal-content"
                    class="overflow-y-auto max-h-[70vh] sm:max-h-[75vh] p-2 border border-gray-200 rounded-md">
                    <!-- Aquí se insertará historial_show.blade.php -->
                </div>

                <!-- Botón de cerrar abajo (opcional, útil en móviles) -->
                <div class="flex justify-center mt-4 sm:mt-6">
                    <button onclick="toggleModal()"
                        class="px-3 sm:px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded text-sm sm:text-base">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Importar Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        function openModal(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modal-content').innerHTML = html;
                    document.getElementById('modal').classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Error al cargar el historial:', err);
                });
        }

        function toggleModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal-content').innerHTML = "";
        }
    </script>
</x-app-layout>
