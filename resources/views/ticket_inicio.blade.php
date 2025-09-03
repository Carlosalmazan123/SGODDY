<x-app-layout>
    <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4"
        x-data="{
            modalOpen: false,
            ticketActual: null,
            filasOcultas: [],
            ocultarFila(id) {
                this.filasOcultas.push(id);
            }
        }">
        <h1 class="text-2xl font-bold mb-4">Listado de Tickets Virtuales</h1>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-center">
                        <th class="border border-gray-300 px-4 py-2">Cliente</th>
                        <th class="border border-gray-300 px-4 py-2">Nombre de la mascota</th>
                        <th class="border border-gray-300 px-4 py-2">Especie</th>
                        <th class="border border-gray-300 px-4 py-2">Tipo del servicio</th>
                        <th class="border border-gray-300 px-4 py-2">Fecha</th>
                        <th class="border border-gray-300 px-4 py-2">Hora</th>
                        <th class="border border-gray-300 px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr x-show="!filasOcultas.includes({{ $ticket->id }})"
                        class="text-center {{ $ticket->estado == 'Atendido' ? 'bg-green-100' : 'bg-red-100' }}">
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->nombre_mascota }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->tipo_mascota }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->servicio->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->fecha_cita }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $ticket->hora_cita }}</td>
                        <td class="border border-gray-300 px-4 py-2 space-x-1">
                            <!-- Ver detalles en modal -->
                            <button @click="modalOpen = true; ticketActual = {{ $ticket->toJson() }}"
                                class="text-blue-500 hover:underline">
                                <ion-icon name="eye-outline" class="h-6 w-6"></ion-icon>
                            </button>

                            <!-- Ocultar fila visualmente -->
                            <button
                                class="text-green-500 hover:text-green-800" title="Atendido"
                                @click.prevent="fetch('/tickets/{{ $ticket->id }}/ocultar', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(() => location.reload())">
                                <ion-icon name="checkmark-done-outline" class="h-6 w-6"></ion-icon>
                            </button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
                <h2 class="text-xl font-bold mb-4">Detalles del Ticket</h2>

                <!-- Botón X para cerrar -->
                <button @click="modalOpen = false"
                    class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>

                <template x-if="ticketActual">
                    <div class="space-y-2 text-left">
                        <p><strong>Cliente:</strong> <span x-text="ticketActual.user.name"></span></p>
                        <p><strong>Mascota:</strong> <span x-text="ticketActual.nombre_mascota"></span></p>
                        <p><strong>Especie:</strong> <span x-text="ticketActual.tipo_mascota"></span></p>
                        <p><strong>Servicio:</strong> <span x-text="ticketActual.servicio.nombre"></span></p>
                        <p><strong>Fecha:</strong> <span x-text="ticketActual.fecha_cita"></span></p>
                        <p><strong>Hora:</strong> <span x-text="ticketActual.hora_cita"></span></p>

                    </div>
                </template>

                <!-- Botón inferior para cerrar -->
                <div class="mt-6 text-right">
                    <button @click="modalOpen = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
