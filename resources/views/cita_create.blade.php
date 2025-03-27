<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Crear Nueva Cita</h2>
    
        <form id="formCita">
            @csrf
            
            <!-- Selección de Paciente -->
            <div class="mb-4">
                <label for="paciente_id" class="block text-sm font-medium text-gray-700">Paciente</label>
                <select id="paciente_id" name="paciente_id" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="">Seleccionar Paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Selección de Propietario -->
            <div class="mb-4">
                <label for="propietario_id" class="block text-sm font-medium text-gray-700">Propietario</label>
                <select id="propietario_id" name="propietario_id" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="">Seleccionar Propietario</option>
                    @foreach($propietarios as $propietario)
                        <option value="{{ $propietario->id }}">{{ $propietario->nombre }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Selección de Servicio -->
            <div class="mb-4">
                <label for="servicio_id" class="block text-sm font-medium text-gray-700">Servicio</label>
                <select id="servicio_id" name="servicio_id" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="">Seleccionar Servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Fecha de la cita -->
            <div class="mb-4">
                <label for="fecha_cita" class="block text-sm font-medium text-gray-700">Fecha de la Cita</label>
                <input type="date" id="fecha_cita" name="fecha_cita" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
    
            <!-- Hora de la cita -->
            <div class="mb-4">
                <label for="hora_cita" class="block text-sm font-medium text-gray-700">Hora de la Cita</label>
                <input  id="hora_cita" name="hora_cita" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
    
            <!-- Estado de la Cita -->
            <div class="mb-4">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado de la Cita</label>
                <select id="estado" name="estado" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="Pendiente" selected>Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
    
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Crear Cita</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#formCita').submit(function(event) {
                event.preventDefault(); // Evita que la página se recargue
                
                let formData = $(this).serialize(); // Serializa los datos del formulario
    
                // Enviar a la primera ruta (citas.store)
                $.ajax({
                    url: "{{ route('citas.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log("Cita creada:", response);
                        
                        // Luego de éxito en citas, enviar a tickets.store
                        $.ajax({
                            url: "{{ route('tickets.store') }}",
                            type: "POST",
                            data: formData,
                            success: function(response) {
                                console.log("Ticket virtual creado:", response);
                                
                                // Redireccionar a la vista citas.index
                                window.location.href = "{{ route('citas.index') }}";
                            },
                            error: function(error) {
                                console.error("Error al crear ticket:", error);
                                alert("Hubo un problema al crear el ticket virtual.");
                            }
                        });
                    },
                    error: function(error) {
                        console.error("Error al crear cita:", error);
                        alert("Hubo un problema al crear la cita.");
                    }
                });
            });
        });
    </script>
    
</x-app-layout>