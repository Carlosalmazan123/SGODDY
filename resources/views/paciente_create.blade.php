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

        <h2 class="text-2xl font-bold mb-4">Registrar Nuevo Paciente</h2>
        
        <form action="{{ route('pacientes.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Nombre del Paciente</label>
                    <input type="text" name="nombre" class="w-full border-gray-300 rounded-md" required>
                </div>
                
                <div class="w-1/2">
                    <label class="block font-medium">Especie</label>
                    <input type="text" name="especie" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Raza</label>
                    <input type="text" name="raza" class="w-full border-gray-300 rounded-md">
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Año de Nacimiento</label>
                    <input type="number" id="anio_nacimiento" name="anio_nacimiento" class="w-full border-gray-300 rounded-md" min="1900" max="2100" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Edad (años)</label>
                    <input type="number" id="edad" name="edad" class="w-full border-gray-300 rounded-md bg-gray-200" readonly>
                </div>
                <div class="w-1/2">
                    <label for="color" class="block font-medium">Color</label>
                    <input type="text" name="color" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="peso" class="block font-medium">Peso en kg</label>
                    <input type="number" name="peso" id="precio"  step="0.01"  class="w-full border-gray-300 rounded-md" required>
       
              
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Sexo</label>
                    <select name="sexo" class="w-full border-gray-300 rounded-md">
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
            </div>
            
            <div class="flex space-x-4 items-center">
                <div class="w-1/3">
                    <label for="imagen" class="block font-medium">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                </div>
                <div class="w-1/3 flex justify-center">
                    <img id="preview" class="w-32 h-32 object-cover rounded-md mt-2 border border-gray-300 shadow">
                </div>
            </div>
            
            <div class="w-full">
                <label for="propietario_id">Propietario (opcional si se agrega uno nuevo):</label>
                <select name="propietario_id" id="propietario_id" class="w-full border-gray-300 rounded-md">
                    <option value="">Seleccione un propietario (opcional)</option>
                    @foreach ($propietarios as $propietario)
                        <option value="{{ $propietario->id }}">{{ $propietario->nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="py-2">
                <button type="button" id="toggleNuevoPropietario" class="px-4 py-2 bg-green-500 text-white rounded">Nuevo Propietario</button>
            </div>
            
            <div id="nuevoPropietarioForm" class="hidden p-4 rounded mt-4 w-full">
                <h3 class="text-xl font-semibold mb-2">Registrar Nuevo Propietario</h3>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label class="block font-medium">Nombre del Propietario</label>
                        <input type="text" name="nuevo_nombre" id="nuevo_nombre" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div class="w-1/2">
                        <label class="block font-medium">Apellido del Propietario</label>
                        <input type="text" name="nuevo_apellido" id="nuevo_apellido" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label class="block font-medium">Teléfono</label>
                        <input type="text" name="nuevo_telefono" id="nuevo_telefono" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div class="w-1/2">
                        <label class="block font-medium">Dirección</label>
                        <input type="text" name="nuevo_direccion" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-4">
                <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>

    <script>
       
    document.getElementById('imagen').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    });
    document.getElementById('toggleNuevoPropietario').addEventListener('click', function() {
    let form = document.getElementById('nuevoPropietarioForm');
    let propietarioSelect = document.getElementById('propietario_id');
    let container = document.getElementById('mainContainer');

    form.classList.toggle('hidden');

    if (!form.classList.contains('hidden')) {
        propietarioSelect.value = ''; // Limpiar el select si se usa nuevo propietario
        container.style.height = container.scrollHeight + 'px'; // Ajustar la altura automáticamente
    } else {
        container.style.height = 'auto'; // Volver a la altura normal
    }
});
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

    // Calcular edad cuando el usuario ingresa el año de nacimiento
    document.getElementById('anio_nacimiento').addEventListener('input', calcularEdad);

    // Calcular edad automáticamente al cargar la página (si hay un año ya ingresado)
    window.onload = calcularEdad;
    </script>
</x-app-layout>
