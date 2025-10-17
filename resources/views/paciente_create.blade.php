<x-app-layout>
    <div class="container mx-auto p-4">
    @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
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
                    <label class="block font-medium">Nombre del Paciente<b class="text-red-600">*</b></label>
                    <input type="text" name="nombre" class="w-full border-gray-300 rounded-md" required>
                </div>
                
                <div class="w-1/2">
                    <label class="block font-medium">Especie<b class="text-red-600">*</b></label>
                    <div id="especie-container">
                        <select name="especie" id="especie-select" class="w-full border-gray-300 rounded-md" required>
                            <option value="">Selecciona una especie</option>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Conejo">Caballo</option>
                            <option value="Hamster">Conejo</option>
                            <option value="Ave">Chivo</option>
                           
                            <option value="Oveja">Oveja</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                
            </div>
            
            <div class="flex space-x-4 ">
                <div class="w-1/2">
                    <label class="block font-medium">Raza<b class="text-red-600">*</b></label>
                    <div id="raza-container">
                      <select name="raza" id="raza-select" class="w-full border-gray-300 rounded-md">
                        <option value="">Selecciona una raza</option>
                      </select>
                    </div>
                  </div>                  
                <div class="w-1/2">
                    <label class="block font-medium">Año de Nacimiento<b class="text-red-600">*</b></label>
                    <select id="anio" name="anio" class="w-full border-gray-300 rounded-md" required>
                       
                    </select>
                 </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium">Edad(años)<b class="text-red-600">*</b></label>
                    <input type="number" id="edad" name="edad" class="w-full border-gray-300 rounded-md bg-gray-200" readonly>
                </div>
                <div class="w-1/2">
                    <label for="color" class="block font-medium">Color<b class="text-red-600">*</b></label>
                    <input type="text" name="color" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="peso" class="block font-medium">Peso en kg<b class="text-red-600">*</b></label>
                    <input type="number" name="peso" id="precio"  step="0.01"  class="w-full border-gray-300 rounded-md" required>              
                </div>
                <div class="w-1/2">
                    <label class="block font-medium">Sexo<b class="text-red-600">*</b></label>
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
    <h3 class="text-xl font-semibold mb-2">Registrar Nuevo Propietario<b class="text-red-600">*</b></h3>
    <div class="flex space-x-4">
        <div class="w-1/2">
            <label class="block font-medium">Nombre del Propietario<b class="text-red-600">*</b></label>
            <input type="text" name="nuevo_nombre" id="nuevo_nombre" class="w-full border-gray-300 rounded-md" placeholder="Ej: Pedro">
        </div>
        <div class="w-1/2">
            <label class="block font-medium">Apellido del Propietario<b class="text-red-600">*</b></label>
            <input type="text" name="nuevo_apellido" id="nuevo_apellido" class="w-full border-gray-300 rounded-md" placeholder="Ej: Pérez">
        </div>
    </div>
    <div class="flex space-x-4 mt-4">
        <div class="w-1/2">
            <label class="block font-medium">Teléfono<b class="text-red-600">*</b></label>
            <input type="number" name="nuevo_telefono" id="nuevo_telefono" class="w-full border-gray-300 rounded-md" value="591">
        </div>
        <div class="w-1/2">
            <label class="block font-medium">CI<b class="text-red-600">*</b></label>
            <input type="text" name="nuevo_ci" id="nuevo_ci" class="w-full border-gray-300 rounded-md" placeholder="Ej: 12345678">
        </div>
    </div>
    <div class="flex space-x-4 mt-4">
        <div class="w-1/2">
            <label class="block font-medium">Dirección</label>
            <input type="text" name="nuevo_direccion" class="w-full border-gray-300 rounded-md" placeholder="Opcional">
        </div>
        <div class="w-1/2">
            <label class="block font-medium">Correo electrónico<b class="text-red-600">*</b></label>
            <input type="text" name="nuevo_correo" class="w-full border-gray-300 rounded-md" placeholder="Ej:pedro@gmail.com">
        </div>
    </div>

    <!-- Checkbox de consentimiento
  
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="opt_in_whatsapp" id="opt_in_whatsapp" class="form-checkbox h-5 w-5 text-green-600" value="1">
            <span class="ml-2 text-gray-700">Acepto recibir mensajes de recordatorios y notificaciones por WhatsApp.</span>
        </label>
    </div>
      -->
</div>

            
            <div class="flex justify-end mt-4 ">
                <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
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
        propietarioSelect.value = '';
        container.style.height = container.scrollHeight + 'px';
    } else {
        container.style.height = 'auto';
    }
});
const especieContainer = document.getElementById('especie-container');

function renderEspecieSelect() {
    especieContainer.innerHTML = `
        <select name="especie" id="especie-select" class="w-full border-gray-300 rounded-md" required>
            <option value="">Selecciona una especie</option>
            <option value="Perro">Perro</option>
            <option value="Gato">Gato</option>
            <option value="Caballo">Caballo</option>
            <option value="Conejo">Conejo</option>
            <option value="Chivo">Chivo</option>
      
            <option value="Oveja">Oveja</option>
            <option value="Otro">Otro</option>
        </select>
    `;
    especieSelect.addEventListener('change', onEspecieChange);
    }
const razaContainer = document.getElementById('raza-container');
const especieSelect = document.getElementById('especie-select');
function showEspecieInput() {
    especieContainer.innerHTML = `
        <input type="text" name="especie" id="especie-input" class="w-full border-gray-300 rounded-md" placeholder="Escribe la nueva especie" required>
    `;
}

function onEspecieChange() {
    if (this.value === 'Otro') {
        showEspecieInput();
    } else {
        currentEspecie = this.value;
        const razas = razasPorEspecie[currentEspecie] || [];
        renderRazaSelect(razas);
    }
}
// Inicializar evento
document.addEventListener('DOMContentLoaded', () => {
    const especieSelect = document.getElementById('especie-select');
    if (especieSelect) {
        especieSelect.addEventListener('change', onEspecieChange);
    }
    });
let currentEspecie = '';
const razasPorEspecie = {
    Perro: ['Labrador', 'Pastor Alemán', 'Pug', 'Bulldog', 'Mestizo','Otra raza'],    
    Gato: ['Persa', 'Siamés', 'Maine Coon', 'Bengalí', 'Mestizo','Otra raza'],
    Caballo: ['Árabe', 'Andaluz', 'Percherón', 'Frisón', 'Mestizo','Otra raza'],
    Conejo: ['Enano', 'Cabeza de león', 'Belier', 'Rex','Otra raza'],
    Chivo: ['Boer', 'Nubian', 'Saanen','Otra raza'],
    
    Oveja: ['Merina', 'Suffolk', 'Dorper','Otra raza'],
    Otro: ['Otra raza']
};

function renderRazaSelect(razas) {
    razaContainer.innerHTML = `
        <select name="raza" id="raza-select" class="w-full border-gray-300 rounded-md">
            <option value="">Selecciona una raza</option>
            ${razas.map(raza => `<option value="${raza}">${raza}</option>`).join('')}
        </select>
    `;

    const newRazaSelect = document.getElementById('raza-select');
    newRazaSelect.addEventListener('change', function () {
        if (this.value === 'Otra raza') {
            showRazaInput();
        }
    });
}

function showRazaInput() {
    razaContainer.innerHTML = `
        <input type="text" name="raza" id="raza-input" class="w-full border-gray-300 rounded-md" placeholder="Escribe la nueva raza">
    `;
}

// Cambiar opciones de raza al seleccionar especie
especieSelect.addEventListener('change', function () {
    currentEspecie = this.value;
    const razas = razasPorEspecie[currentEspecie] || [];
    renderRazaSelect(razas);
});

// Enviar nueva raza al backend si es necesario
document.querySelector('form').addEventListener('submit', function (e) {
    const razaInput = document.getElementById('raza-input');
    if (razaInput && razaInput.value.trim() !== '') {
        e.preventDefault(); // Detener envío mientras se guarda la raza
        const nuevaRaza = razaInput.value.trim();

        // Obtener ID de especie desde un campo hidden o convertir texto a ID (esto es un ejemplo)
        const especieId = especieSelect.options[especieSelect.selectedIndex].getAttribute('data-id');

        fetch('/razas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nombre: nuevaRaza,
                especie_id: especieId // Este valor debe venir del backend, no del texto
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!razasPorEspecie[currentEspecie].includes(data.nombre)) {
                razasPorEspecie[currentEspecie].splice(
                    razasPorEspecie[currentEspecie].length - 1,
                    0,
                    data.nombre
                );
            }
            renderRazaSelect(razasPorEspecie[currentEspecie]);
            const select = document.getElementById('raza-select');
            select.value = data.nombre;
            this.submit(); // Reenviar el formulario ahora sí
        })
        .catch(error => {
            console.error('Error al guardar la nueva raza:', error);
        });
    }
});

const selectAnio = document.getElementById('anio');
const currentYear = new Date().getFullYear();
const startYear = currentYear - 35;

for (let year = currentYear; year >= startYear; year--) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    selectAnio.appendChild(option);
}

function calcularEdad() {
    let anioNacimiento = document.getElementById('anio').value;
    let anioActual = new Date().getFullYear();
    let edad = anioActual - anioNacimiento;

    if (anioNacimiento && edad >= 0) {
        document.getElementById('edad').value = edad;
    } else {
        document.getElementById('edad').value = '';
    }
}

document.getElementById('anio').addEventListener('input', calcularEdad);
window.onload = calcularEdad;
</script>

</x-app-layout>
