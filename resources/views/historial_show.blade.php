<!-- resources/views/historial_show.blade.php -->


    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md sm:p-8">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Datos del paciente -->
        <h2 class="text-xl md:text-2xl font-bold mb-4 text-center">Historial Clínico de {{$paciente->nombre}}</h2>
        
        <div class="border-b pb-4 mb-4 text-gray-700 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Especie:</strong> {{ $paciente->especie }}</p>
                <p><strong>Raza:</strong> {{ $paciente->raza ?? 'No especificado' }}</p>
                <p><strong>Edad:</strong> {{ $paciente->edad }} años</p>
                <p><strong>Sexo:</strong> {{ $paciente->sexo }}</p>
            </div>
        
            <div>
                <p><strong>Color:</strong> {{ $paciente->color }}</p>
                <p><strong>Peso:</strong> {{ $paciente->peso }} kg</p>
                <p><strong>Propietario:</strong> {{ $paciente->relPropietario->nombre }} {{ $paciente->relPropietario->apellido }}</p>
                <p><strong>Teléfono:</strong> {{ $paciente->relPropietario->telefono }}</p>
                <p><strong>Dirección:</strong> {{ $paciente->relPropietario->direccion }}</p>
            </div>
        </div>
        
        <!-- Historial clínico -->
        @if($historial && $historial->count() > 0)
            <div class="overflow-x-auto max-h-96">
                <p><strong>Signos Clínicos:</strong> {{ $historial->anamnesis ?? '-' }}</p>
                <p><strong>Diagnóstico:</strong> {{ $historial->diagnostico ?? '-' }}</p>
                <p><strong>Examen:</strong> {{ $historial->examen ?? '-' }}</p>

                <table class="w-full border-collapse border border-gray-300 mt-4 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">Fecha</th>
                            <th class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">Tratamiento</th>
                            <th class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_object($historial) && is_array($historial->fecha) && is_array($historial->tratamiento) && is_array($historial->observaciones))
                            @foreach($historial->fecha as $index => $fecha)
                                <tr class="odd:bg-gray-100 even:bg-white text-center">
                                    <td class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">
                                        {{ $fecha }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">
                                        {{ isset($historial->tratamiento[$index]) ? $historial->tratamiento[$index] : '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 sm:px-6 sm:py-3">
                                        {{ isset($historial->observaciones[$index]) ? $historial->observaciones[$index] : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">No hay historial clínico disponible.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
               
        @else
            <p class="text-gray-500 italic mt-4">No hay historial clínico disponible.</p>
            <a href="{{ route('historial.create', $paciente->id) }}"
                class="mt-4 inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition duration-200">
                Crear Historial Clínico
            </a>
        @endif
    </div>
    