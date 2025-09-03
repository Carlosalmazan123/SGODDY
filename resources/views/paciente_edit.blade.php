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
    
            <div class="flex space-x-4 ">
                <div class="w-1/2">
                    <label class="block font-medium">Nombre del Paciente</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $paciente->nombre) }}" class="w-full border-gray-300 rounded-md" required>
                </div>
    
                <div class="w-1/2">
                    <label class="block font-medium">Especie</label>
                    <div id="especie-container">
                        <select name="especie" id="especie-select" class="w-full border-gray-300 rounded-md" required>
                            <option value="">Selecciona una especie</option>
                            @php
                                $especies = ['Perro', 'Gato', 'Caballo', 'Conejo', 'Chivo', 'Tortuga', 'Oveja'];
                            @endphp
                            @foreach ($especies as $especie)
                                <option value="{{ $especie }}" {{ $paciente->especie === $especie ? 'selected' : '' }}>{{ $especie }}</option>
                            @endforeach
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="flex space-x-4 mb-4">
                <div class="w-1/2">
                    <label class="block font-medium">Raza</label>
                    <div id="raza-container">
                        <select name="raza" id="raza-select" class="w-full border-gray-300 rounded-md">
                            <option value="">Selecciona una raza</option>
                            <option value="{{ $paciente->raza }}" selected>{{ $paciente->raza }}</option>
                            <option value="Otra">Otra</option>
                        </select>
                    </div>
                </div>
    
        <div class="w-1/2">
    <label class="block font-medium">Año de Nacimiento</label>
    <select id="anio" name="anio" class="w-full border-gray-300 rounded-md" required>
        @php $anioActual = date('Y'); @endphp
        @for ($i = $anioActual; $i >= 1990; $i--)
            <option value="{{ $i }}" {{ $paciente->anio == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
</div>
            </div>
    <div class="flex space-x-4 mb-4">
          
<div class="w-1/2">
    <label class="block font-medium">Edad (años)</label>
    <input type="number" id="edad" name="edad" value="{{ $paciente->edad }}" class="w-full border-gray-300 rounded-md bg-gray-200" readonly>
</div>
    
                <div class="w-1/2">
                    <label for="color" class="block font-medium">Color</label>
                    <input type="text" name="color" value="{{ $paciente->color }}" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
    
            <div class="flex space-x-4 mb-4">
                <div class="w-1/2">
                    <label for="peso" class="block font-medium">Peso en kg</label>
                    <input type="number" name="peso" step="0.01" value="{{ $paciente->peso }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Sexo</label>
                    <select name="sexo" class="w-full border-gray-300 rounded-md">
                        <option value="Macho" {{ $paciente->sexo === 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ $paciente->sexo === 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>
            </div>
    
            <div class="flex space-x-4 items-center mb-4">
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
    
            <div class="flex justify-end">
                <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>
    </div>

    <script>
     const especieContainer = document.getElementById('especie-container');
    const razaContainer = document.getElementById('raza-container');
document.addEventListener('DOMContentLoaded', function () {
        const anioNacimiento = document.getElementById('anio');
        const edadInput = document.getElementById('edad');

        function calcularEdad(anio) {
            const anioActual = new Date().getFullYear();
            return anioActual - anio;
        }

        function actualizarEdad() {
            const anio = parseInt(anioNacimiento.value);
            edadInput.value = calcularEdad(anio);
        }

        // Calcular edad con el valor inicial cargado
        actualizarEdad();

        // Calcular edad cuando se cambie el valor
        anioNacimiento.addEventListener('change', actualizarEdad);
    });
    function renderEspecieInput() {
        especieContainer.innerHTML = `
            <input type="text" name="especie" id="especie-input" value="{{ $paciente->especie }}" class="w-full border-gray-300 rounded-md" required>
        `;
    }

    function renderEspecieSelect() {
        especieContainer.innerHTML = `
            <select name="especie" id="especie-select" class="w-full border-gray-300 rounded-md" required>
                <option value="">Selecciona una especie</option>
                @foreach ($especies as $especie)
                    <option value="{{ $especie }}" {{ $paciente->especie === $especie ? 'selected' : '' }}>{{ $especie }}</option>
                @endforeach
                <option value="Otro">Otro</option>
            </select>
        `;
        document.getElementById('especie-select').addEventListener('change', onEspecieChange);
    }

    function onEspecieChange() {
        if (this.value === 'Otro') {
            renderEspecieInput();
        }
    }

    function renderRazaInput() {
        razaContainer.innerHTML = `
            <input type="text" name="raza" id="raza-input" value="{{ $paciente->raza }}" class="w-full border-gray-300 rounded-md" required>
        `;
    }

    function renderRazaSelect() {
        razaContainer.innerHTML = `
            <select name="raza" id="raza-select" class="w-full border-gray-300 rounded-md">
                <option value="">Selecciona una raza</option>
                <option value="{{ $paciente->raza }}" selected>{{ $paciente->raza }}</option>
                <option value="Otra">Otra</option>
            </select>
        `;
        document.getElementById('raza-select').addEventListener('change', onRazaChange);
    }

    function onRazaChange() {
        if (this.value === 'Otra') {
            renderRazaInput();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const especieSelect = document.getElementById('especie-select');
        if (especieSelect) especieSelect.addEventListener('change', onEspecieChange);

        const razaSelect = document.getElementById('raza-select');
        if (razaSelect) razaSelect.addEventListener('change', onRazaChange);

        // Activar campos si vienen como "Otro"/"Otra"
        if ("{{ $paciente->especie }}" === "Otro") renderEspecieInput();
        if ("{{ $paciente->raza }}" === "Otra") renderRazaInput();
    });
    </script>
</x-app-layout>
