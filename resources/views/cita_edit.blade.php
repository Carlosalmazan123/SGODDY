<x-app-layout>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Editar Cita</h1>
    @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('PUT')
    
        <!-- Paciente -->
        <div>
            <label for="paciente_id" class="block text-sm font-medium text-gray-700">Paciente*</label>
            <select id="paciente_id" name="paciente_id" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccionar Paciente</option>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $paciente->id == $cita->paciente_id ? 'selected' : '' }}>
                        {{ $paciente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Propietario -->
        <div>
            <label for="propietario_nombre" class="block text-sm font-medium text-gray-700">Propietario</label>
            <input type="text" id="propietario_nombre" name="propietario_nombre" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $cita->propietario_nombre }}" readonly>
            <input type="hidden" id="propietario_id" name="propietario_id" value="{{ $cita->propietario_id }}">
        </div>
    
        <!-- Servicio -->
        <div>
            <label for="servicio_id" class="block text-sm font-medium text-gray-700">Servicio*(Seleccione una fecha primero)</label>
            <select id="servicio_id" name="servicio_id" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccionar Servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ $servicio->id == $cita->servicio_id ? 'selected' : '' }}>
                        {{ $servicio->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Fecha -->
        <div>
            <label for="fecha_cita" class="block text-sm font-medium text-gray-700">Fecha de la Cita*</label>
            <input type="date" id="fecha_cita" name="fecha_cita" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $cita->fecha_cita }}" required>
        </div>
    
        <!-- Hora -->
        <div>
            <label for="hora_cita" class="block text-sm font-medium text-gray-700">Hora de la Cita*</label>
            <select id="hora_cita" name="hora_cita" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Seleccione una hora --</option>
                @foreach($horas as $hora)
                    <option value="{{ $hora }}" {{ $hora == $cita->hora_cita ? 'selected' : '' }}>
                        {{ $hora }}
                    </option>
                @endforeach
            </select>
            
        </div>
    
        <!-- Estado -->
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado de la Cita*</label>
            <select id="estado" name="estado" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Confirmada" {{ $cita->estado == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="Cancelada" {{ $cita->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
    
        <!-- Botón -->
        <div class="md:col-span-2 flex justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-md shadow-md focus:outline-none focus:ring-4 focus:ring-blue-300">
                Actualizar Cita
            </button>
        </div>
    </form>
    
</div>
<script>
    const pacientesData = @json($pacientes->mapWithKeys(function($p) {
        return [$p->id => ['propietario_id' => $p->propietario->id, 'propietario_nombre' => $p->propietario->nombre]];
    }));

    document.getElementById('paciente_id').addEventListener('change', function () {
        const selectedPacienteId = this.value;
        const propietario = pacientesData[selectedPacienteId];

        if (propietario) {
            document.getElementById('propietario_id').value = propietario.propietario_id;
            document.getElementById('propietario_nombre').value = propietario.propietario_nombre;
        } else {
            document.getElementById('propietario_id').value = '';
            document.getElementById('propietario_nombre').value = '';
        }
    });

    document.getElementById('servicio_id').addEventListener('change', function () {
        let servicioSeleccionado = this.options[this.selectedIndex].text.toLowerCase();
        let selectHorario = document.getElementById('hora_cita');
        let fechaSeleccionada = document.getElementById("fecha_cita").value;

        selectHorario.innerHTML = '<option value="">-- Seleccione una hora --</option>';

        if (!servicioSeleccionado || servicioSeleccionado === "seleccionar servicio") {
            alert("⚠️ Por favor, seleccione un tipo de servicio antes de elegir un horario.");
            return;
        }

        let horarios = [];
        let duracionServicio = 0;

        fetch(`/servicios/${this.value}/duracion`)
            .then(response => response.json())
            .then(data => {
                duracionServicio = data.duracion;
                let duracionHoras = parseInt(duracionServicio.split(':')[0]);
                let duracionMinutos = parseInt(duracionServicio.split(':')[1]);
                let duracionTotalMinutos = duracionHoras * 60 + duracionMinutos;
                let intervaloHoras = duracionTotalMinutos / 60;

                const agregarHorarios = (inicio, fin, intervaloHoras, duracionTotalMinutos) => {
                    const horariosTemp = [];
                    const intervaloMinutos = Math.round(intervaloHoras * 60);
                    const inicioMin = Math.round(inicio * 60);
                    const finMin = Math.round(fin * 60);
                    const excesoPermitido = duracionTotalMinutos > 60 ? 30 : 0;

                    for (let minuto = inicioMin; minuto < finMin + excesoPermitido; minuto += intervaloMinutos) {
                        if (minuto + duracionTotalMinutos <= finMin + excesoPermitido) {
                            let horas = Math.floor(minuto / 60).toString().padStart(2, '0');
                            let minutos = (minuto % 60).toString().padStart(2, '0');
                            horarios.push(`${horas}:${minutos}`);
                        }
                    }
                };

                agregarHorarios(8.5, 12, intervaloHoras, duracionTotalMinutos);
                agregarHorarios(15, 20, intervaloHoras, duracionTotalMinutos);

                selectHorario.innerHTML = '<option value="">Cargando horarios...</option>';

                fetch(`/citas-ocupadas?fecha=${fechaSeleccionada}`)
                    .then(response => response.json())
                    .then(citasOcupadas => {
                        selectHorario.innerHTML = '<option value="">-- Seleccione una hora --</option>';

                        let horasBloqueadas = new Set();

                        citasOcupadas.forEach(cita => {
                            let [h, m] = cita.hora_cita.split(":").map(Number);
                            let [dh, dm] = cita.duracion.split(":").map(Number);

                            let inicio = h * 60 + m;
                            let fin = inicio + dh * 60 + dm;

                            for (let i = inicio; i < fin; i += 30) {
                                let horas = Math.floor(i / 60).toString().padStart(2, '0');
                                let minutos = (i % 60).toString().padStart(2, '0');
                                horasBloqueadas.add(`${horas}:${minutos}`);
                            }
                        });

                        horarios.forEach((hora) => {
                            let [h, m] = hora.split(":").map(Number);
                            let inicio = h * 60 + m;
                            let fin = inicio + duracionTotalMinutos;

                            let hayInterseccion = false;
                            for (let i = inicio; i < fin; i += 30) {
                                let horas = Math.floor(i / 60).toString().padStart(2, '0');
                                let minutos = (i % 60).toString().padStart(2, '0');
                                let bloque = `${horas}:${minutos}`;
                                if (horasBloqueadas.has(bloque)) {
                                    hayInterseccion = true;
                                    break;
                                }
                            }

                            let option = document.createElement("option");
                            option.value = hora;
                            option.textContent = hora;

                            if (hayInterseccion) {
                                option.disabled = true;
                                option.textContent += " (No disponible)";
                            }

                            selectHorario.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error al obtener las citas ocupadas:", error));
            })
            .catch(error => console.error("Error al obtener la duración del servicio:", error));
    });

    document.addEventListener("DOMContentLoaded", function () {
        const fechaInput = document.getElementById("fecha_cita");
        const servicioSelect = document.getElementById("servicio_id");

        // Inicialmente deshabilitar el select de servicio
        servicioSelect.disabled = true;

        fechaInput.addEventListener("change", function () {
            if (fechaInput.value) {
                servicioSelect.disabled = false;

                // Reiniciar opciones del select de servicio
                servicioSelect.selectedIndex = 0;

                // Para limpiar todas las opciones menos la primera:
                // while (servicioSelect.options.length > 1) {
                //     servicioSelect.remove(1);
                // }
            } else {
                servicioSelect.disabled = true;
                servicioSelect.selectedIndex = 0;
            }
        });

        // Establecer los valores iniciales al cargar la página
        const selectedServicio = document.getElementById('servicio_id').value;
        if (selectedServicio) {
            document.getElementById('servicio_id').dispatchEvent(new Event('change'));
        }

        const selectedPacienteId = document.getElementById('paciente_id').value;
        if (selectedPacienteId) {
            document.getElementById('paciente_id').dispatchEvent(new Event('change'));
        }
    });
</script>

</x-app-layout>