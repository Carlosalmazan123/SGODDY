<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Veterinaria ODDY</title>
    <!-- Fonts -->
    <link rel="icon" href="{{ asset('images/pawprint.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @if  (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js']) 
    @else
        @vite('resources/css/style.css')
    @endif
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="/vendor/ionicons/ionicons.esm.js"></script>
    <script nomodule src="/vendor/ionicons/ionicons.js"></script>
     <style>[x-cloak] { display: none !important; }</style>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<meta name="theme-color" content="#2563eb">
<link rel="apple-touch-icon" href="{{ asset('images/images.png') }}">
</head>

<body
    class="font-sans antialiased dark:bg-black dark:text-white/50 opacity-0 transition-opacity duration-1000 delay-2000">
    <div class="font-sans">
        <!-- Barra superior -->
        <!-- Navbar -->
        <nav class="bg-white shadow-md dark:bg-black z-50 relative" x-data="{ open: false }">
            <div class="container mx-auto flex flex-wrap items-center justify-between p-4">
                <div class="text-xl md:text-2xl font-bold text-blue-600">Clínica<span
                        class="text-gray-500">veterinaria</span>ODY</div>
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <ul class="hidden md:flex space-x-6 items-center" id="menu">
                    <li>
                        <button id="darkmode">🌙</button>
                    </li>
                    <li class="text-blue-600 font-semibold"><a href="{{ url('/') }}">Inicio</a></li>
                    <li><a href="{{ url('/clinica') }}">La Clínica</a></li>

                    <li><a href="#">Planes de Salud</a></li>
                    <li class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->hasRole('cliente'))
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                <div>{{ Auth::user()->email }}</div>
                                                <div class="ms-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                    {{ __('Cerrar Sesión') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @else
                                    <a href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black dark:text-white">Iniciar Sesión</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Registrarse
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </li>
                </ul>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ul class="mt-10 space-y-4 px-6">
                        <li>
                            <button id="darkmode1">🌙</button>
                        </li>
                        <li class="text-blue-600 font-semibold"><a href="{{ url('/') }}">Inicio</a></li>
                        <li><a href="{{ url('/clinica') }}">La Clínica</a></li>
                        <li><a href="#">Nuestros Centros</a></li>
                        <li><a href="#">Planes de Salud</a></li>
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->hasRole('cliente'))
                                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                                        <div class="px-4">
                                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                                {{ Auth::user()->name }}</div>
                                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>

                                        <div class="mt-3 space-y-1">

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-responsive-nav-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                    {{ __('Cerrar Sesión') }}
                                                </x-responsive-nav-link>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <li><a href="{{ url('/dashboard') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                            Dashboard
                                        </a></li>
                                @endif
                            @else
                                <li><a href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black dark:text-white">Iniciar Sesión</a></li>

                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                            Registrarse
                                        </a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Hamburger -->
        <div id="calendar" class="pt-4 px-4 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:text-white">
        </div>
    </div>
    <div id="modal_alerta" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="relative p-6 w-full max-w-md bg-red-600 rounded-lg shadow-md dark:bg-gray-700">
            <p class="mt-2 text-white dark:text-white">No puedes hacer reservas en fechas pasadas..</p>
            <div class="mt-4 flex justify-end">
                <button id="cloze-modal"
                    class="cerrarr_modal bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition ml-2">Cerrar</button>
            </div>
        </div>
    </div>
    <div id="modal_sesion" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-md dark:bg-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inicia sesión</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Debes iniciar sesión para realizar una reserva.</p>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Iniciar sesión</a>
                <button id="cerrarr-modal"
                    class="cerrarr_modal bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition ml-2">Cerrar</button>
            </div>
        </div>
    </div>
    <div id="modal_formulario"
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50 p-4 sm:p-6 md:p-8">
        <div class="relative p-2 w-full max-w-lg sm:max-w-md bg-white rounded-lg shadow-md dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Reservar para el día <span id="dia"></span>
                </h3>
                <button type="button" id="cerrar-modal"
                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" id="form_reserva" enctype="multipart/form-data" class="p-4 space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg ">
                    <div>
                        <label class="block text-sm font-medium">Nombre de usuario</label>
                        <input type="text" name="email" id="nameInput" value="{{ $userName }}"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" disabled>
                        <input type="hidden" id="user_id" value="{{ auth()->id() }}">
                        @php
                           $pacientesInfo = [];

                                if (isset($propietario) && $propietario) {
                                    foreach ($propietario->pacientes as $paciente) {
                                        $pacientesInfo[] = [
                                            'id' => $paciente->id,
                                            'nombre' => $paciente->nombre,
                                            'especie' => $paciente->especie,
                                        ];
                                    }
                                }
                        @endphp
                        <label class="block text-sm font-medium">Nombre de la mascota</label>
                        @if ($propietario && $propietario->pacientes->count())
                            <select name="paciente_id" id="nombre_mascota"
                                class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" required>
                                <option value="">-- Seleccione una mascota --</option>
                                @foreach ($propietario->pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" id="nombre_mascota" autocomplete="off" name="nombre_mascota"
                                class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" required>
                        @endif
                        <label class="block text-sm font-medium">Fecha de reserva</label>
                        <input type="text" id="fecha_reserva" name="fecha_cita"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Correo Electrónico</label>
                        <input type="text" name="email" id="email" value="{{ $emailSesion }}"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" disabled>
                        <label class="block text-sm font-medium ">Tipo de Mascota</label>
                        <select name="tipo_mascota" id="tipo_mascota"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white"
                            autocomplete="off" required>
                            <option value="">-- Seleccione --</option>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Caballo">Caballo</option>
                            <option value="Conejo">Conejo</option>
                            <option value="Chivo">Chivo</option>
                            <option value="Tortuga">Tortuga</option>
                            <option value="Oveja">Oveja</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <label class="block text-sm font-medium">Tipo de servicio</label>
                        <select name="servicio_id" autocomplete="off" id="servicio_id"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($servicios as $servicio)
                                @if (Str::contains(strtolower($servicio->nombre), ['consulta', 'peluquería']))
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label class="block text-sm font-medium">Hora de reserva</label>
                        <select id="hora_reserva" name="hora_cita" autocomplete="off"
                            class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-white" required>
                            <option value="">-- Seleccione una hora --</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-blue-700 text-white rounded-lg hover:bg-blue-800 focus:outline-none">
                        <ion-icon class="w-5 h-5" name="save-outline"></ion-icon> Guardar
                    </button>
                </div>

            </form>
        </div>
    </div>
    <footer class="bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 py-6 mt-10">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-sm">&copy; 2025 Clínica Veterinaria ODY. Todos los derechos reservados.</p>
            <p class="text-sm mt-2">Dirección: Calle Beni Casi frente al hospital Eduardo Eguía, Tupiza, Bolivia | Teléfono: +591 65468983</p>
        </div>
    </footer>
    <script>
        var isAuthenticated = @json($isAuthenticated); // Se pasa la variable isAuthenticated
        var emailSesion = @json($emailSesion);
        var userName = @json($userName);
        const pacientesInfo = @json($pacientesInfo);
        
       document.getElementById('nombre_mascota')?.addEventListener('change', function () {
    const selectedPacienteId = parseInt(this.value);
    const tipoMascotaSelect = document.getElementById('tipo_mascota');

    // Buscar el paciente correspondiente dentro del array de objetos
    const paciente = pacientesInfo.find(p => p.id === selectedPacienteId);

    if (paciente && paciente.especie) {
        let especieStr = String(paciente.especie); // Asegura que sea string

        for (let i = 0; i < tipoMascotaSelect.options.length; i++) {
            if (tipoMascotaSelect.options[i].value.toLowerCase() === especieStr.toLowerCase()) {
                tipoMascotaSelect.selectedIndex = i;
                break;
            }
        }
    } else {
        tipoMascotaSelect.selectedIndex = 0; // "-- Seleccione --"
    }
});
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.remove("opacity-0");
        });
        var a;
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var horariosCache = {}; // Objeto para almacenar las respuestas en caché
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                selectable: true,
                allDaySlot: false,
                events: '/virtual',
                dateClick: function(info) {
                    a = info.dateStr;
                    var numDia = new Date(a).getDay();
                    var dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                    var fechaSeleccionada = new Date(a);
                    var fechaActual = new Date();
                    fechaActual.setHours(0, 0, 0, 0);
                    fechaSeleccionada.setHours(0, 0, 0,
                    0); // Eliminar la hora para comparar solo la fecha
                    var fechaMinimaPermitida = new Date(fechaActual);
                    fechaMinimaPermitida.setDate(fechaActual.getDate() - 2);
                    if (fechaSeleccionada <= fechaMinimaPermitida) {
                        document.getElementById("modal_alerta").classList.remove(
                        "hidden"); // Mostrar modal de alerta
                        return; // Salir de la función
                    }
                    if (!isAuthenticated) { // Si no está autenticado
                        document.getElementById("modal_sesion").classList.remove("hidden");
                    } else {
                        if (numDia === 6) { // Si es domingo
                            alert("No se atiende los días domingos.");
                        } else {
                            document.getElementById("modal_formulario").classList.remove("hidden");
                            document.getElementById('dia').textContent = dias[numDia] + " " + a;
                            document.getElementById("fecha_reserva").value = a;
                        }
                    }
                }
            });
            calendar.render();
            document.getElementById("cerrar-modal").addEventListener("click", () => {
                document.getElementById("modal_formulario").classList.add("hidden");
            });
            document.getElementById("cerrarr-modal").addEventListener("click", () => {
                document.getElementById("modal_sesion").classList.add("hidden");
            });
            document.getElementById("cloze-modal").addEventListener("click", () => {
                document.getElementById("modal_alerta").classList.add("hidden");
            });
            document.getElementById("modal_sesion").addEventListener("click", function(event) {
                if (event.target === this) {
                    this.classList.add("hidden");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Cerrar el modal si se hace clic fuera del contenido
            modal.addEventListener("click", function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const modalFormulario = document.getElementById("modal_formulario");
            const modalSesion = document.getElementById("modal_sesion");
            const modalAlerta = document.getElementById("modal_alerta");
            const closeModalVirtual = document.getElementById("close-modal");
            const closeModalFormulario = document.getElementById("cerrar-modal");
            const closeModalSesion = document.getElementById("cerrarr-modal");
            const closeModalAlerta = document.getElementById("cloze-modal");
            // Función para cerrar el modal
            function closeModal(modal) {
                if (modal) {
                    modal.classList.add("hidden");
                }
            }
            if (closeModalFormulario) {
                closeModalFormulario.addEventListener("click", function() {
                    closeModal(modalFormulario);
                });
            }
            if (closeModalSesion) {
                closeModalSesion.addEventListener("click", function() {
                    closeModal(modalSesion);
                });
            }
            if (closeModalAlerta) {
                closeModalAlerta.addEventListener("click", function() {
                    closeModal(modalAlerta);
                });
            }
            // Opcional: cerrar modal al hacer clic fuera de él
            window.addEventListener("click", function(event) {
                if (event.target === modalFormulario) {
                    closeModal(modalFormulario);
                }
                if (event.target === modalSesion) {
                    closeModal(modalSesion);
                }
                if (event.target === modalAlerta) {
                    closeModal(modalAlerta);
                }
            });
        });
    document.getElementById('servicio_id').addEventListener('change', function () {
    let servicioSeleccionado = this.options[this.selectedIndex].text.toLowerCase();
    let selectHorario = document.getElementById('hora_reserva');
    let fechaSeleccionada = document.getElementById("fecha_reserva").value;

    selectHorario.innerHTML = '<option value="">-- Seleccione una hora --</option>';

    if (!servicioSeleccionado || servicioSeleccionado === "-- seleccione --") {
        alert("⚠️ Por favor, seleccione un tipo de servicio antes de elegir un horario.");
        return;
    }

    let horarios = [];
    let duracionServicio = 0;

    // Obtener duración del servicio seleccionado
    fetch(`/servicios/${this.value}/duracion`)
        .then(response => response.json())
        .then(data => {
            duracionServicio = data.duracion; // formato esperado "HH:MM"
            let [horas, minutos] = duracionServicio.split(":").map(Number);
            let duracionTotalMinutos = horas * 60 + minutos;
            let intervaloHoras = duracionTotalMinutos / 60;

            // Generar horarios base (mañana y tarde)
            const agregarHorarios = (inicio, fin, intervaloHoras, duracionTotalMinutos) => {
                const intervaloMinutos = Math.round(intervaloHoras * 60);
                const inicioMin = Math.round(inicio * 60);
                const finMin = Math.round(fin * 60);
                const excesoPermitido = duracionTotalMinutos > 60 ? 30 : 0;

                for (let minuto = inicioMin; minuto < finMin + excesoPermitido; minuto += intervaloMinutos) {
                    if (minuto + duracionTotalMinutos <= finMin + excesoPermitido) {
                        let h = Math.floor(minuto / 60).toString().padStart(2, '0');
                        let m = (minuto % 60).toString().padStart(2, '0');
                        horarios.push(`${h}:${m}`);
                    }
                }
            };

            agregarHorarios(8.5, 12, intervaloHoras, duracionTotalMinutos); // 08:30–12:00
            agregarHorarios(15, 20, intervaloHoras, duracionTotalMinutos); // 15:00–20:00

            selectHorario.innerHTML = '<option value="">Cargando horarios...</option>';

            // Verificar horarios ocupados
            fetch(`/citas-ocupadas?fecha=${fechaSeleccionada}`)
                .then(response => response.json())
                .then(citasOcupadas => {
                    selectHorario.innerHTML = '<option value="">-- Seleccione una hora --</option>';

                    let horasBloqueadas = new Set();

                    // 🔹 Registrar TODAS las horas ocupadas por cualquier servicio
                    citasOcupadas.forEach(cita => {
                        let [h, m] = cita.hora_cita.split(":").map(Number);
                        let [dh, dm] = cita.duracion.split(":").map(Number);

                        let inicio = h * 60 + m;
                        let fin = inicio + dh * 60 + dm;

                        // 🔴 Bloquear todo el rango completo ocupado por esa cita
                        for (let i = inicio; i < fin; i += 15) { // cada 15 minutos
                            let bloqueH = Math.floor(i / 60).toString().padStart(2, '0');
                            let bloqueM = (i % 60).toString().padStart(2, '0');
                            horasBloqueadas.add(`${bloqueH}:${bloqueM}`);
                        }
                    });

                    // Obtener hora actual (para evitar horas pasadas)
                    let ahora = new Date();
                    let fechaHoy = ahora.toISOString().split("T")[0];
                    let minutosActuales = ahora.getHours() * 60 + ahora.getMinutes();

                    horarios.forEach(hora => {
                        let [h, m] = hora.split(":").map(Number);
                        let inicio = h * 60 + m;
                        let fin = inicio + duracionTotalMinutos;
                        let hayInterseccion = false;

                        // 🔹 Revisar si alguna parte de este rango choca con horasBloqueadas
                        for (let i = inicio; i < fin; i += 15) {
                            let bloqueH = Math.floor(i / 60).toString().padStart(2, '0');
                            let bloqueM = (i % 60).toString().padStart(2, '0');
                            if (horasBloqueadas.has(`${bloqueH}:${bloqueM}`)) {
                                hayInterseccion = true;
                                break;
                            }
                        }

                        let option = document.createElement("option");
                        option.value = hora;
                        option.textContent = hora;

                        // Deshabilitar si ya pasó la hora de hoy
                        if (fechaSeleccionada === fechaHoy && inicio <= minutosActuales) {
                            option.disabled = true;
                            option.textContent += " (Hora pasada)";
                        }

                        // Deshabilitar si interseca con otro servicio
                        if (hayInterseccion) {
                            option.disabled = true;
                            option.textContent += " (No disponible)";
                        }

                        selectHorario.appendChild(option);
                    });

                    // Si ya no hay horas disponibles hoy, sugerir cambiar fecha
                    if (fechaSeleccionada === fechaHoy) {
                        let horasDisponibles = Array.from(selectHorario.options).some(opt => !opt.disabled && opt.value !== "");
                        if (!horasDisponibles) {
                            let aviso = document.createElement("option");
                            aviso.disabled = true;
                            aviso.textContent = "No hay horarios disponibles hoy. Seleccione otra fecha.";
                            selectHorario.appendChild(aviso);
                        }
                    }
                })
                .catch(error => console.error("Error al obtener las citas ocupadas:", error));
        })
        .catch(error => console.error("Error al obtener la duración del servicio:", error));
});



        document.getElementById("form_reserva").addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma tradicional
            let fecha = document.getElementById("fecha_reserva").value;
            let hora = document.getElementById("hora_reserva").value;
            var userId = @json(auth()->id());
            if (!fecha || !hora) {
                alert("⚠️ Por favor, selecciona una fecha y una hora.");
                return;
            }
            if (!userId) {
                alert("⚠️ Debes iniciar sesión para realizar una reserva.");
                document.getElementById("modal_sesion").classList.remove("hidden");
                return;
            }
            const formData = new FormData();

            // Añadir campos al formData
            formData.append('user_id', document.getElementById("user_id").value);
            formData.append('nombre_mascota', document.getElementById("nombre_mascota").value);

            formData.append('tipo_mascota', document.getElementById("tipo_mascota").value);
            formData.append('fecha_cita', fecha);
            formData.append('hora_cita', hora);
            formData.append('servicio_id', document.getElementById("servicio_id").value);
          
            fetch("/reservar-cita", {
                    method: "POST",
                    credentials: "include", // ← Importante para enviar cookies de sesión
                    headers: {

                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        const precio = data.precio_servicio ?? 0;
                       
                        const modal = document.createElement("div");
                        modal.innerHTML = `
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-xl text-left">
                    <h2 class="text-2xl font-bold text-green-600 mb-4 text-center">🎫 Ticket generado</h2>
                    <div class="text-gray-800 space-y-2">
                        <p><strong>Código:</strong> ${data.ticket_id ?? 'N/A'}</p>
                        <p><strong>Fecha:</strong> ${data.fecha_cita}</p>
                        <p><strong>Hora:</strong> ${data.hora_cita}</p>
                        <p><strong>Servicio:</strong> ${data.servicio}</p>
                        <p><strong>Mascota:</strong> ${data.nombre_mascota} (${data.tipo_mascota})</p>
                        <p><strong>Aviso importante:</strong> Favor de tomarle captura a la pantalla</p>
                    </div>
                    <div class="mt-6 text-center">
                        <button id="cerrar_modal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        `;
                        document.body.appendChild(modal);

                        document.getElementById("cerrar_modal").addEventListener("click", () => {
                            modal.remove();
                            location.reload(); // 🔁 Recarga la página
                        });

                        document.getElementById("form_reserva").reset();
                    }
                })


                .catch(error => console.error("Error al reservar:", error));
        });
    </script>
    <script>
        const root = document.documentElement;
        const toggle = document.getElementById('darkmode');
        const toggle1 = document.getElementById('darkmode1');
        // Cargar preferencia
        if (localStorage.getItem('theme') === 'dark') {
            root.classList.add('dark');
            toggle.textContent = '🌞';
        }

        toggle.addEventListener('click', () => {
            root.classList.toggle('dark');
            const isDark = root.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            toggle.textContent = isDark ? '🌞' : '🌙';
        });
        if (localStorage.getItem('theme') === 'dark') {
            root.classList.add('dark');
            toggle1.textContent = '🌞';
        }
        toggle1.addEventListener('click', () => {
            root.classList.toggle('dark');
            const isDark = root.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            toggle1.textContent = isDark ? '🌞' : '🌙';
        });

        if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js')
    .then(() => console.log("✅ Service Worker registrado"))
    .catch(err => console.log("❌ Error en SW:", err));
}
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
</body>

</html>
