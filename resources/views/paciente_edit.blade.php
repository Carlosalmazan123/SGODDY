<x-app-layout>
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-full max-w-3xl mx-auto" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="list-disc">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div id="mainContainer" class="w-full max-w-3xl mx-auto p-4 bg-white rounded-lg shadow mt-4 flex flex-col items-center transition-all duration-300">
        <h2 class="text-2xl font-bold mb-4">Editar Paciente</h2>
        
        <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Nombre del Paciente</label>
                    <input type="text" name="nombre" value="{{ $paciente->nombre }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                
                <div class="w-1/2">
                    <label class="block font-medium">Especie</label>
                    <input type="text" name="especie" value="{{ $paciente->especie }}" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Raza</label>
                    <input type="text" name="raza" value="{{ $paciente->raza }}" class="w-full border-gray-300 rounded-md">
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Edad (años)</label>
                    <input type="number" name="edad" value="{{ old('edad', $paciente->edad) }}" class="w-full border-gray-300 rounded-md" min="0" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                
                <div class="w-1/2">
                    <label class="block font-medium">Color</label>
                    <input type="text" name="color" value="{{ $paciente->color }}" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="peso" class="block font-medium">Peso</label>
                    <input type="number" name="peso" id="peso" value="{{ $paciente->peso }}" step="0.001" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Sexo</label>
                    <select name="sexo" class="w-full border-gray-300 rounded-md">
                        <option value="Macho" {{ $paciente->sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ $paciente->sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>
            </div>
            
            <div class="flex space-x-4 items-center">
                <div class="w-1/3">
                    <label for="imagen" class="block font-medium">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                </div>
                <div class="w-1/3 flex justify-center">
                    <img id="preview" src="{{ asset('storage/'.$paciente->imagen) }}" class="w-32 h-32 object-cover rounded-md mt-2 border border-gray-300 shadow">
                </div>
            </div>
            
            <div class="w-full">
                <label for="propietario_id">Propietario:</label>
                <select name="propietario_id" id="propietario_id" class="w-full border-gray-300 rounded-md">
                    <option value="">Seleccione un propietario</option>
                    @foreach ($propietarios as $propietario)
                        <option value="{{ $propietario->id }}" {{ $paciente->propietario_id == $propietario->id ? 'selected' : '' }}>
                            {{ $propietario->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex justify-end mt-4">
                <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>
    </div>

    <script>
    function calcularEdad() {
        let anioNacimiento = document.getElementById('anio_nacimiento').value;
        let anioActual = new Date().getFullYear();
        let edad = anioActual - anioNacimiento;

        if (anioNacimiento && edad >= 0) {
            document.getElementById('edad').value = edad;
        } else {
            document.getElementById('edad').value = '';
        }
    }
    
    document.getElementById('anio_nacimiento').addEventListener('input', calcularEdad);
    window.onload = calcularEdad;
    
    document.getElementById('imagen').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    });
    </script>
</x-app-layout>
