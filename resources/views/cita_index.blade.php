
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

    <!-- Botón restaurar (colócalo en la vista) -->
<button id="btn-restaurar" class="hidden px-4 py-1.5 bg-yellow-500 text-white rounded hover:bg-yellow-600">
    Restaurar la última cita
</button>
<script>
        // Desaparecer el mensaje después de 1 segundo
        setTimeout(function() {
            let message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 1000); // 1000 ms = 1 segundo
    </script>

<div class="bg-white mt-3 shadow-md rounded-lg overflow-hidden border border-gray-200"
x-data="{
            modalOpen: false,
            ticketActual: null,
            filasOcultas: [],
            ocultarFila(id) {
                this.filasOcultas.push(id);
            }
        }">
    
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr >
                        <th class="border px-4 py-2">Paciente</th>
                        <th class="border px-4 py-2">Dueño del paciente</th>
                        <th class="border px-4 py-2">Servicio</th>
                        <th class="border px-4 py-2">Fecha de la cita</th>
                        <th class="border px-4 py-2">Hora de la cita</th>
                        <th class="border px-4 py-2">Estado</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $index => $cita)

                    <tr
                    id="cita-{{ $cita->id }}"
                        >
                        <td class="border px-4 py-2">{{ $cita->relPaciente->nombre }}</td>
                        <td class="border px-4 py-2">{{ $cita->relPaciente->relPropietario->nombre }}</td>
                        <td class="border px-4 py-2">{{ $cita->servicio->nombre }}</td>
                        <td class="border px-4 py-2">{{ $cita->fecha_cita }}</td>
                        <td class="border px-4 py-2">{{ $cita->hora_cita }}</td>
                        <td class="border px-4 py-2">{{ $cita->estado }}</td>
                        <td class="border px-4 py-2">
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
                <p class="flex items-center gap-2">
                    <ion-icon name="paw-outline" class="text-yellow-600 w-5 h-5"></ion-icon>
                    <strong>Paciente:</strong><span x-text="citaSeleccionada.rel_paciente?.nombre || '-'"></span>
                </p>
                <p class="flex items-center gap-2">
                    <ion-icon name="person-outline" class="text-blue-600 w-5 h-5"></ion-icon>
                    <strong>Dueño:</strong> <span x-text="citaSeleccionada.rel_paciente?.rel_propietario?.nombre || '-'"></span>
                </p>
            </div>
            <div class="pt-2">
                <p class="flex items-center gap-2">
                    <ion-icon name="calendar-outline" class="text-green-600 w-5 h-5"></ion-icon>
                    <strong>Fecha:</strong> <span x-text="citaSeleccionada.fecha_cita"></span>
                </p>
                <p class="flex items-center gap-2">
                    <ion-icon name="time-outline" class="text-purple-600 w-5 h-5"></ion-icon>
                    <strong>Hora:</strong> <span x-text="citaSeleccionada.hora_cita"></span>
                </p>
            </div>
            <div class="pt-2 flex items-center gap-2">
                <ion-icon name="medkit-outline" class="text-red-500 w-5 h-5"></ion-icon>
                <strong>Motivo:</strong><span x-text="citaSeleccionada.servicio?.nombre || '-'"></span>
            </div>
            <div class="pt-2 flex items-center gap-2">
                <ion-icon name="bookmark-outline" class="text-gray-600 w-5 h-5"></ion-icon>
                <strong>Estado:</strong> 
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

        <div class="flex flex-wrap justify-center sm:justify-between gap-2 mt-6">
    @can('cita.edit')
    <a 
        :href="'/citas/' + citaSeleccionada.id + '/edit'" 
        class="flex-1 sm:flex-none px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-center flex items-center justify-center gap-2"
    >
        <ion-icon name="create-outline" class="w-5 h-5"></ion-icon>
        Editar
    </a>
    @endcan

            <button
                                            class="flex-1 sm:flex-none px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center justify-center gap-2 btn-ocultar"
                                            data-id="{{ $cita->id }}">
                                            <ion-icon name="checkmark-done-outline" class="h-6 w-6"></ion-icon> Atendido
                                        </button>

    @if($cita->servicio && 
        (\Illuminate\Support\Str::startsWith(\Illuminate\Support\Str::lower($cita->servicio->nombre), 'cirugía') || 
        \Illuminate\Support\Str::startsWith(\Illuminate\Support\Str::lower($cita->servicio->nombre), 'eutanasia') ||
        \Illuminate\Support\Str::startsWith(\Illuminate\Support\Str::lower($cita->servicio->nombre), 'sedación') ||
        \Illuminate\Support\Str::startsWith(\Illuminate\Support\Str::lower($cita->servicio->nombre), 'anestesia')))
        <a href="{{ route('citas.contrato', $cita->id) }}" 
            target="_blank"
            class="flex-1 sm:flex-none px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center gap-2"
        >
            <ion-icon name="reader-outline" class="h-6 w-6"></ion-icon> Contrato
        </a>
    @endif

    <button 
        @click="openModal = false" 
        class="flex-1 sm:flex-none px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg flex items-center justify-center gap-2"
    >
        <ion-icon name="close-outline" class="w-5 h-5"></ion-icon>
        Cerrar
    </button>
</div>
    </div>
    </div>
</div>
                                
                                <!-- Editar Cita -->
                                @can("cita.edit")
                                <a href="{{ route('citas.edit', $cita) }}" class="py-1 text-blue-500 rounded hover:text-blue-600">
                                    <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                </a>
                                @endcan
                                                       <!-- <a href="#" 
                                        onclick="enviarRecordatorio(
                                            '{{ $cita->propietario->telefono ?? '' }}',
                                            '{{ $cita->propietario->nombre ?? 'Propietario' }}',
                                            '{{ $cita->paciente->nombre ?? 'Mascota' }}',
                                            '{{ $cita->fecha_cita ?? '' }}',
                                            '{{ $cita->hora_cita ?? '' }}'
                                        )"

                                        >
                                            <ion-icon title="Enviar recordatorio" name="send-outline" class="h-6 w-6"></ion-icon> 
                                        </a>-->

                                                                <button
                                            class="text-green-500 hover:text-green-800 btn-ocultar"
                                            data-id="{{ $cita->id }}">
                                            <ion-icon name="checkmark-done-outline" class="h-6 w-6"></ion-icon>
                                        </button>


                               
                            </div>
                        </td>
                        
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>

                </div>
</div>
            <div class="mt-4">
                {{ $citas->links() }}
            </div>
        </div>
  

</div>
<script>
   window.citas = @json($citasJson);

document.addEventListener('DOMContentLoaded', function () {
    // Ajusta selector al tbody de tu tabla de citas si lo tienes:
    const tablaBody = document.querySelector('#tabla-citas tbody') || document.querySelector('table tbody');
    const btnRestaurar = document.getElementById('btn-restaurar');
    const csrf = '{{ csrf_token() }}'; // Blade token
    let ultimoOcultado = null; // { id, html, nextSiblingId, parent }

    function mostrarBotonRestaurar(show) {
        if (!btnRestaurar) return;
        if (show) btnRestaurar.classList.remove('hidden');
        else btnRestaurar.classList.add('hidden');
    }

    // Delegación: captura clicks en cualquier .btn-ocultar dentro del tbody
    if (tablaBody) {
        tablaBody.addEventListener('click', async function (e) {
            const boton = e.target.closest('.btn-ocultar');
            if (!boton) return;

            const citaId = boton.dataset.id;
            const fila = document.getElementById(`cita-${citaId}`);
            if (!fila) return console.warn('Fila no encontrada', citaId);

            try {
                const resp = await fetch(`/citas/${citaId}/ocultar`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await resp.json();

                if (!resp.ok || !data.success) {
                    const msg = data.error || 'No se pudo ocultar la cita';
                    return alert(msg);
                }

                // Guardamos info para poder restaurar exactamente en la misma posición
                ultimoOcultado = {
                    id: citaId,
                    html: fila.outerHTML,
                    nextSiblingId: fila.nextElementSibling ? fila.nextElementSibling.id : null,
                    parent: fila.parentNode // elemento DOM (tbody)
                };

                // Quitamos la fila de la vista
                fila.remove();

                // Mostrar botón restaurar
                mostrarBotonRestaurar(true);
            } catch (err) {
                console.error('Error ocultando cita:', err);
                alert('Ocurrió un error al ocultar la cita.');
            }
        });
    } else {
        console.warn('No se encontró el body de la tabla. Asegúrate de tener <tbody> en la tabla.');
    }

    // Click en "Restaurar último"
    if (btnRestaurar) {
        btnRestaurar.addEventListener('click', async function () {
            if (!ultimoOcultado) {
                alert('No hay registros para restaurar.');
                return;
            }

            try {
                const resp = await fetch(`/citas/${ultimoOcultado.id}/restaurar`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await resp.json();

                if (!resp.ok || !data.success) {
                    const msg = data.error || 'No se pudo restaurar la cita';
                    return alert(msg);
                }

                // Reinsertamos la fila en su posición original
                const parent = ultimoOcultado.parent || tablaBody;
                if (!parent) {
                    // fallback: append al final
                    (tablaBody || document.querySelector('table tbody')).insertAdjacentHTML('beforeend', ultimoOcultado.html);
                } else {
                    if (ultimoOcultado.nextSiblingId) {
                        const next = document.getElementById(ultimoOcultado.nextSiblingId);
                        if (next) {
                            next.insertAdjacentHTML('beforebegin', ultimoOcultado.html);
                        } else {
                            parent.insertAdjacentHTML('beforeend', ultimoOcultado.html);
                        }
                    } else {
                        parent.insertAdjacentHTML('beforeend', ultimoOcultado.html);
                    }
                }

                // Limpiamos memoria y ocultamos botón restaurar
                ultimoOcultado = null;
                mostrarBotonRestaurar(false);

                // NOTA: no es necesario volver a ligar listeners a .btn-ocultar,
                // la delegación en tablaBody ya los captura porque el elemento nuevo está en el DOM.
            } catch (err) {
                console.error('Error restaurando cita:', err);
                alert('Ocurrió un error al restaurar la cita.');
            }
        });
    }
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
