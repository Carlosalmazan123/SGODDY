
<x-app-layout>
 

        <div class="container mx-auto p-4 bg-white rounded-xl shadow mt-4 ">
            <h2 class="text-2xl font-bold mb-4">Gestión de Citas</h2>
            
            <a href="{{ route('citas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Agendar Cita</a>
            @if (session('success'))
    <div id="success-message" class="mt-3 p-2 bg-green-200 text-green-700 rounded">
        {{ session('success') }}
    </div>
    
@endif
@if(session('error'))
<div id="success-message" class="bg-red-500 text-white mt-3 p-2 rounded relative" role="alert">
    {{ session('error') }}
</div>
@endif
<script>
        // Desaparecer el mensaje después de 1 segundo
        setTimeout(function() {
            let message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 1000); // 1000 ms = 1 segundo
    </script>

<div class="overflow-x-auto"
x-data="{
            modalOpen: false,
            ticketActual: null,
            filasOcultas: [],
            ocultarFila(id) {
                this.filasOcultas.push(id);
            }
        }">
    <table class="min-w-full mt-4 border-collapse border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Paciente</th>
                        <th class="border p-2">Dueño del paciente</th>
                        <th class="border p-2">Servicio</th>
                        <th class="border p-2">Fecha de la cita</th>
                        <th class="border p-2">Hora de la cita</th>
                        <th class="border p-2">Estado</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $index => $cita)

                    <tr
                    id="cita-{{ $cita->id }}"
                        class="border">
                        <td class="p-2">{{ $cita->relPaciente->nombre }}</td>
                        <td class="p-2">{{ $cita->relPaciente->relPropietario->nombre }}</td>
                        <td class="p-2">{{ $cita->servicio->nombre }}</td>
                        <td class="p-2">{{ $cita->fecha_cita }}</td>
                        <td class="p-2">{{ $cita->hora_cita }}</td>
                        <td class="p-2">{{ $cita->estado }}</td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <!-- Ver Cita -->
                                <div x-data="{ openModal: false, citaSeleccionada: {} }">
                                    <button 
                                        @click="openModal = true; citaSeleccionada = citas[{{ $index }}]"
                                        class="text-green-500 hover:text-green-700 font-bold py-1 rounded"
                                        title="Ver Cita"
                                    >
                                        <ion-icon name="eye-outline" class="h-6 w-6" title="visualizar"></ion-icon>
                                    </button>
                        
                                    <!-- Modal de detalles -->
                                    <div 
                                        x-show="openModal"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-90"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-90"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                    >
                                        <div class="bg-white p-6 rounded-2xl shadow-xl w-11/12 md:w-2/3 lg:w-1/2 relative overflow-y-auto max-h-[90vh]">
                                            <button 
                                                @click="openModal = false" 
                                                class="absolute top-3 right-3 text-gray-600 hover:text-black text-2xl"
                                            >
                                                &times;
                                            </button>
                        
                                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Detalles de la Cita</h2>
                        
                                            <div class="space-y-3 text-left divide-y divide-gray-200">
                                                <div class="pt-1">
                                                    <p><strong>🐾 Paciente:</strong> <span x-text="citaSeleccionada.rel_paciente.nombre"></span></p>
                                                    <p><strong>👤 Dueño:</strong> <span x-text="citaSeleccionada.rel_paciente.rel_propietario.nombre"></span></p>
                                                </div>
                                                <div class="pt-2">
                                                    <p><strong>📅 Fecha:</strong> <span x-text="citaSeleccionada.fecha_cita"></span></p>
                                                    <p><strong>⏰ Hora:</strong> <span x-text="citaSeleccionada.hora_cita"></span></p>
                                                </div>
                                                <div class="pt-2">
                                                    <p><strong>🩺 Motivo:</strong> <span x-text="citaSeleccionada.servicio.nombre"></span></p>
                                                </div>
                                                <div class="pt-2">
                                                    <strong>📌 Estado:</strong> 
                                                    <span 
                                                        class="px-3 py-1 rounded-full text-white text-sm font-medium inline-block mt-1"
                                                        :class="{
                                                            'bg-yellow-500': citaSeleccionada.estado === 'Pendiente',
                                                            'bg-green-600': citaSeleccionada.estado === 'Confirmada',
                                                            'bg-red-500': citaSeleccionada.estado === 'Cancelada'
                                                        }"
                                                        x-text="citaSeleccionada.estado"
                                                    ></span>
                                                </div>
                                            </div>
                        
                                            <div class="flex flex-col sm:flex-row justify-between gap-2 mt-6">
                                                @can('cita.edit')
                                                <a 
                                                    :href="'/citas/' + citaSeleccionada.id + '/edit'" 
                                                    class="w-full sm:w-auto px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-center"
                                                >
                                                    ✏️ Editar
                                                </a>
                                                @endcan
                                               
                                                @can('cita.delete')
                                                <form 
                                                    :action="'/citas/' + citaSeleccionada.id" 
                                                    method="POST" 
                                                    @submit="return confirm('¿Estás seguro de eliminar esta cita?')"
                                                    class="w-full sm:w-auto"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg"
                                                    >
                                                        🗑️ Eliminar
                                                    </button>
                                                </form>
                                                @endcan
                                                <button 
                                                    @click="openModal = false" 
                                                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg"
                                                >
                                                    ✖️ Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       @if($cita->servicio && $cita->servicio->nombre === 'Cirugía')
    <a href="{{ route('citas.pdf', $cita->id) }}"
        target="_blank"
        class="text-green-500 hover:text-green-600 py-1 rounded-lg">
        <ion-icon name="reader-outline" class="h-6 w-6"></ion-icon>
    </a>
@endif
                                <!-- Editar Cita -->
                                @can("cita.edit")
                                <a href="{{ route('citas.edit', $cita) }}" class="py-1 text-blue-500 rounded hover:text-blue-600">
                                    <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                </a>
                                @endcan
                   <a href="#" 
  onclick="enviarRecordatorio(
    '{{ $cita->propietario->telefono ?? '' }}',
    '{{ $cita->propietario->nombre ?? 'Propietario' }}',
    '{{ $cita->paciente->nombre ?? 'Mascota' }}',
    '{{ $cita->fecha_cita ?? '' }}',
    '{{ $cita->hora_cita ?? '' }}'
)"

>
    <ion-icon title="Enviar recordatorio" name="send-outline" class="h-6 w-6"></ion-icon> 
</a>

                        <button
    class="text-green-500 hover:text-green-800 btn-ocultar"
      data-id="{{ $cita->id }}">
    <ion-icon name="checkmark-done-outline" class="h-6 w-6"></ion-icon>
</button>


                                @can("cita.delete")
                                <!-- Eliminar Cita -->
                                <form action="{{ route('citas.destroy', $cita) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="py-1 text-red-500 rounded hover:text-red-600">
                                        <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $citas->links() }}
            </div>
        </div>
  

</div>
<script>
    window.citas = @json($citasJson);
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-ocultar').forEach(function (boton) {
        boton.addEventListener('click', function () {
            let citaId = this.getAttribute('data-id');

            fetch(`/citas/${citaId}/ocultar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    let fila = document.getElementById(`cita-${citaId}`);
                    fila.remove(); // Elimina la fila visualmente
                } else {
                    alert('No se pudo ocultar la cita');
                }
            })
            .catch(error => {
                console.error('Error capturado:', error);
            });
        });
    });
});
function enviarRecordatorio(telefono, nombre, pacienteNombre, fecha, hora) {
    fetch("{{ route('whatsapp.recordatorio') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            telefono: telefono,
            nombre: nombre,
            paciente: { nombre: pacienteNombre },
            fecha: fecha,
            hora: hora
        }) 
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ Recordatorio enviado correctamente.");
        } else {
             console.error('Detalles del error:', data.details);
        alert("⚠️ " + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert("❌ Error al enviar el recordatorio.");
    });
}
</script>
    </div>
</x-app-layout>
