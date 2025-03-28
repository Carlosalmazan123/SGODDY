<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite("resources/css/style.css")
    @endif
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50 opacity-0 transition-opacity duration-1000 delay-2000"> 
    <div class="font-sans">
        <!-- Barra superior -->
        <!-- Navbar -->
        <nav class="bg-white shadow-md dark:bg-black z-50 relative"  x-data="{ open: false }">
            <div class="container mx-auto flex flex-wrap items-center justify-between p-4">
                <div class="text-xl md:text-2xl font-bold text-blue-600">Clínica<span class="text-gray-500">veterinaria</span>ODDY</div>
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <ul class="hidden md:flex space-x-6 items-center" id="menu" >
                    <li class="text-blue-600 font-semibold"><a href="{{ url('/') }}">Inicio</a></li>
                    <li><a href="#">La Clínica</a></li>
                    <li><a href="#">Nuestros Centros</a></li>
                    <li><a href="#">Planes de Salud</a></li>
                    <li  class="flex items-center space-x-4">
                        @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->hasRole('cliente'))
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->email }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @endif                  
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black dark:text-white">Iniciar Sesión</a>
        
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                    </li>
                </ul>
            </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <ul class="mt-10 space-y-4 px-6">
                <li class="text-blue-600 font-semibold"><a href="{{ url('/') }}">Inicio</a></li>
                    <li><a href="#">La Clínica</a></li>
                    <li><a href="#">Nuestros Centros</a></li>
                    <li><a href="#">Planes de Salud</a></li>
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->hasRole('cliente'))
                            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                                <div class="px-4">
                                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
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
                               <li><a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a></li> 
                            @endif
                        @else
                          <li><a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black dark:text-white">Iniciar Sesión</a></li>  

                            @if (Route::has('register'))
                              <li><a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
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
                <button id="cloze-modal" class="cerrarr_modal bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition ml-2">Cerrar</button>
            </div>
        </div>
    </div>
    <div id="contenedor" class="contenedor">
        <div class="rueda"></div>
    </div>
  <!-- Main modal -->
  <div id="modal_virtual" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
    <div class="relative p-4 w-full max-w-md max-h-full bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Reservar para el día  <span id="dia"> </span>
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" id="close-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
              </div>
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Turno Mañana -->
                        <div>
                            <div id="respuesta_horario"></div>
                            <center><b class="text-lg text-center text-gray-700 dark:text-gray-200">Turno mañana</b></center>
                            <div class="grid gap-2 mt-2">
                                <button id="h1"  class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    08:30 - 09:30
                                </button>
                                <button id="h2" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    09:30 - 10:30
                                </button>
                                <button id="h3" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    10:30 - 11:30
                                </button>
                                <button id="h4" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    11:30 - 12:00
                                </button>
                            </div>
                        </div>
                
                        <!-- Turno Tarde -->
                        <div>
                            <center><b class="text-lg text-gray-700 dark:text-gray-200">Turno tarde</b></center>
                            <div class="grid gap-2 mt-2">
                                <button id="h5" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    15:00 - 16:00
                                </button>
                                <button id="h6" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    16:00 - 17:00
                                </button>
                                <button id="h7" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    17:00 - 18:00
                                </button>
                                <button id="h8" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    18:00 - 20:00
                                </button>
                                
                            </div>
                        </div>
                    </div>
                </div>
    
              
          </div>
      </div>
    
      <div id="modal_sesion" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="relative p-6 w-full max-w-md bg-white rounded-lg shadow-md dark:bg-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inicia sesión</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Debes iniciar sesión para realizar una reserva.</p>
            <div class="mt-4 flex justify-end">
                <a href="{{ route("login") }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Iniciar sesión</a>
                <button id="cerrarr-modal" class="cerrarr_modal bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition ml-2">Cerrar</button>
            </div>
        </div>
    </div>
  <div id="modal_formulario" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
    <div class="relative p-4 w-full max-w-md max-h-full bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Reservar para el día  <span id="dia"> </span>
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" id="cerrar-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <form action="{{ route("tickets.store") }}" method="POST">
              @csrf
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="">Nombre de usuario</label>
                            <input type="text" name="email" id="nameInput" value="{{ $userName }}"  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" disabled>
                               <label for="">Nombre de la mascota</label>
                        <input type="text" name="nombre_mascota" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">                   
                        <label for="">Fecha de reserva</label>
                        <input type="text" id="fecha_reserva" name="fecha_cita" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" readonly>
                    </div>
                    <div>
                        <label for="">Correo Electronico</label>
                            <input type="text" name="email" id="email" value="{{ $emailSesion }}"  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" disabled>
                      
                            <label for="">Tipo de servicio</label>
                            <select name="servicio_id" id="servicio_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" required>
                                <option value="">-- Seleccione --</option>
                            
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                    <label for="">Hora de reserva</label>
                        <input type="text" id="hora_reserva" name="hora_cita" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" readonly>     
                    </div>
                </div>
                    </div>
                  <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <ion-icon class="h-5 w-5 p-1"  name="save-outline"></ion-icon> Guardar
                  </button>
                </form>
          </div>
      </div>
      <script>
        var isAuthenticated = @json($isAuthenticated); 
        var emailSesion = @json($emailSesion);
        var userName = @json($userName);  
    
        document.addEventListener("DOMContentLoaded", function () {
            document.body.classList.remove("opacity-0");
    
            const modalVirtual = document.getElementById("modal_virtual");
            const modalFormulario = document.getElementById("modal_formulario");
            const modalSesion = document.getElementById("modal_sesion");
            const modalAlerta = document.getElementById("modal_alerta");
    
            const closeModalVirtual = document.getElementById("close-modal");
            const closeModalFormulario = document.getElementById("cerrar-modal");
            const closeModalSesion = document.getElementById("cerrarr-modal");
            const closeModalAlerta = document.getElementById("cloze-modal");
    
            const calendarEl = document.getElementById('calendar');
            let horariosCache = {};  // Cache de horarios
    
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                selectable: true,
                allDaySlot: false,
                events: '/virtual',
                dateClick: function(info) {
                    let a = info.dateStr;
                    let numDia = new Date(a).getDay();
                    let dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                    let fechaSeleccionada = new Date(a);
                    let fechaActual = new Date();
                    fechaActual.setHours(0, 0, 0, 0);
                    fechaSeleccionada.setHours(0, 0, 0, 0); 
    
                    setTimeout(() => {
                        document.getElementById("contenedor").classList.add("hidden");
                    }, 500);  
    
                    let fechaMinimaPermitida = new Date(fechaActual);
                    fechaMinimaPermitida.setDate(fechaActual.getDate() - 2);
    
                    if (fechaSeleccionada <= fechaMinimaPermitida) {
                        document.getElementById("modal_alerta").classList.remove("hidden");
                        return;
                    }
    
                    if (!isAuthenticated) {
                        document.getElementById("modal_sesion").classList.remove("hidden");
                    } else {
                        if (numDia === 6) { 
                            alert("No se atiende los días domingos.");
                        } else {
                            document.getElementById("modal_virtual").classList.remove("hidden");
                            document.getElementById('dia').textContent = dias[numDia] + " " + a;
                            if (horariosCache[a]) {
                                actualizarHorarios(horariosCache[a]);
                            } else {
                                $.get("/horario", { fecha: a }, function(datos) {
                                    horariosCache[a] = datos;
                                    actualizarHorarios(datos);
                                });
                            }
                        }
                    }
                }
            });
    
            function actualizarHorarios(datos) {
                document.getElementById("contenedor").classList.add("hidden");
    
                $('#h1, #h2, #h3, #h4, #h5, #h6, #h7, #h8')
                    .attr('disabled', false)
                    .removeClass('bg-red-500');
    
                const horasMapeadas = {
                    '08:30 - 09:30': '#h1',
                    '09:30 - 10:30': '#h2',
                    '10:30 - 11:30': '#h3',
                    '11:30 - 12:00': '#h4',
                    '15:00 - 16:00': '#h5',
                    '16:00 - 17:00': '#h6',
                    '17:00 - 18:00': '#h7',
                    '18:00 - 20:00': '#h8'
                };
    
                if (datos.ocupadas && datos.ocupadas.length > 0) {
                    datos.ocupadas.forEach(function(hora) {
                        if (horasMapeadas[hora]) {
                            $(horasMapeadas[hora])
                                .attr('disabled', true)
                                .addClass('bg-red-500');
                        }
                    });
                }
    
                $("#h1, #h2, #h3, #h4, #h5, #h6, #h7, #h8").click(function() {
                    let hora = $(this).attr("id").substring(1); 
                    let fecha = document.getElementById('dia').textContent;
    
                    $.post("/reservar", { fecha: fecha, hora: hora }, function(respuesta) {
                        if (respuesta.exito) {
                            alert("Reserva realizada con éxito");
                            horariosCache[fecha].ocupadas.push(respuesta.hora);
                            $(this).attr('disabled', true).addClass('bg-red-500');
                        } else {
                            alert("Error al realizar la reserva");
                        }
                    });
                });
            }
    
            // Cerrar modales al hacer clic en los botones dentro del modal
            if (closeModalVirtual) {
                closeModalVirtual.addEventListener("click", function () {
                    modalVirtual.classList.add("hidden");
                });
            }
            if (closeModalFormulario) {
                closeModalFormulario.addEventListener("click", function () {
                    modalFormulario.classList.add("hidden");
                });
            }
            if (closeModalSesion) {
                closeModalSesion.addEventListener("click", function () {
                    modalSesion.classList.add("hidden");
                });
            }
            if (closeModalAlerta) {
                closeModalAlerta.addEventListener("click", function () {
                    modalAlerta.classList.add("hidden");
                });
            }
    
            // Cerrar modales al hacer clic fuera del contenido
            window.addEventListener("click", function (event) {
                if (event.target === modalVirtual) modalVirtual.classList.add("hidden");
                if (event.target === modalFormulario) modalFormulario.classList.add("hidden");
                if (event.target === modalSesion) modalSesion.classList.add("hidden");
                if (event.target === modalAlerta) modalAlerta.classList.add("hidden");
            });
    
            calendar.render();
        });
    </script>
    
   <style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    button:disabled {
    pointer-events: none;  /* Desactiva todos los eventos del ratón, como el hover */
    background-color: #eb1818 !important; /* Color rojo para el botón deshabilitado (bg-red-500) */
}
.contenedor { 
 
  display: none;
  place-content: center;
  height: 100vh;
  color: #000;
}

.cargando { 
  position: relative; 
  color: #FFF;
  margin-top: 2em;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.rueda {
  border: 10px solid rgba(9, 245, 9, 0.548);
  border-radius: 50%;
  border-left-color: transparent;
  width: 80px;
  height: 80px;
  animation: giro 1s linear infinite;
}
@keyframes giro {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
</body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  crossorigin="anonymous">
</html>
