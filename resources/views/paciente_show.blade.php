<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-2xl shadow-lg mt-6 max-w-4xl">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-6 text-center">Detalles de la Mascota</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4 text-gray-700 text-sm md:text-base">
                @php
                    $detalles = [
                        'Nombre' => $paciente->nombre,
                        'Especie' => $paciente->especie,
                        'Raza' => $paciente->raza ?? 'No especificado',
                        'Edad' => $paciente->edad . ' años',
                        'Sexo' => $paciente->sexo,
                        'Color' => $paciente->color,
                        'Peso' => $paciente->peso . ' kg',
                        'Propietario' => $paciente->relPropietario->nombre . ' ' . $paciente->relPropietario->apellido,
                        'Teléfono del Propietario' => $paciente->relPropietario->telefono,
                        'Fecha de Registro' => $paciente->created_at->format('d/m/Y')
                    ];
                @endphp
                
                @foreach ($detalles as $key => $value)
                    <p><span class="font-semibold">{{ $key }}:</span> {{ $value }}</p>
                @endforeach
            </div>

            <div class="flex flex-col items-center">
                @if ($paciente->imagen)
                    <img src="{{ asset('storage/'.$paciente->imagen) }}" 
                         alt="Imagen de {{ $paciente->nombre }}" 
                         class="w-48 md:w-64 h-48 md:h-64 object-cover rounded-xl shadow-md border border-gray-300">
                @else
                    <span class="text-gray-500 italic">No tiene imagen</span>
                @endif
            </div>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-md transition">Volver</a>
            <a href="{{ route('pacientes.edit', $paciente) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">Editar</a>
        
            <button onclick="toggleModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition">Ver Historial Clínico</button>
            <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este paciente?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-md transition">Eliminar</button>
            </form>
        </div>

        <!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg max-w-3xl w-full mx-4">
       
        <div class="overflow-y-auto max-h-80 p-2 border border-gray-200 rounded-md">
            @if ($paciente->historial->isNotEmpty())
                @include('historial_show', ['historial' => $paciente->historial->last()])
            @else
                <p class="text-gray-500 italic text-center">No hay historial clínico disponible.</p> <br>
                <div class="flex justify-center">
                    <a href="{{ route('historial.create', $paciente->id) }}"
                        class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition duration-200">
                        Crear Historial Clínico
                    </a>
                </div>
                <div class="flex justify-center p-2">
                 <button onclick="toggleModal()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">Cerrar</button>
                </div>
            @endif
        </div>        

        <div class="flex justify-center mt-4 space-x-6">

            
           @if ($paciente->historial->isNotEmpty())
   

    <!-- Ver todos los historiales -->
    <a href="{{ route('historial.index', $paciente->id) }}"
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
        Ver Todos los Historiales
    </a>

    <!-- Editar último historial -->
    <a href="{{ route('historial.edit', [$paciente->id, $paciente->historial->last()->id]) }}" 
       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
       Editar Historial
    </a>

    <!-- Generar reporte PDF -->
    
                 <button onclick="toggleModal()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">Cerrar</button>
@endif

        </div>
    </div>
</div>

        
    </div>

    <script>
        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden');
        }
    </script>
    
</x-app-layout>
