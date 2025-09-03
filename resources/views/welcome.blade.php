<!DOCTYPE html>
<html lang="es" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Veterinaria ODDY</title>
    <!-- Fonts -->
    <link rel="icon" href="{{ asset("images/pawprint.png") }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script type="module" src="/vendor/ionicons/ionicons.esm.js"></script>
    <script nomodule src="/vendor/ionicons/ionicons.js"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite("resources/css/style.css")
    @endif
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="/vendor/ionicons/ionicons.esm.js"></script>
    <script nomodule src="/vendor/ionicons/ionicons.js"></script>
     <style>[x-cloak] { display: none !important; }</style>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

 @laravelPWA
</head>
<body class="bg-white font-sans antialiased dark:bg-black dark:text-white/50 opacity-0 transition-opacity duration-1000 delay-2000">
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
                    <li><a href="#">La Clínica</a></li>

                    <li><a href="#">Planes de Salud</a></li>
                    <li class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user())
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
                        <li><a href="#">La Clínica</a></li>
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
   
    <div class="font-sans">

        <!-- Contenedor principal -->
<div class="relative w-full">

    <!-- Carrusel: fondo (capa 0) -->
    <div id="default-carousel" class="absolute inset-0 w-full h-full z-0 overflow-hidden" data-carousel="slide">
        <div class="relative h-64 md:h-96 lg:h-[32rem] overflow-hidden">
            <div class="flex transition-transform duration-1000 ease-in-out h-full" id="carousel-images">
                <div class="w-full h-full flex-shrink-0" data-carousel-item>
                    <img src="https://www.simbiotia.com/wp-content/uploads/diseno-de-clinicas-veterinarias.jpg" class="w-full h-full object-cover" alt="...">
                </div>
                <div class="w-full h-full flex-shrink-0" data-carousel-item>
                    <img src="https://www.simbiotia.com/wp-content/uploads/diseno-de-clinicas-veterinarias.jpg" class="w-full h-full object-cover" alt="...">
                </div>
                <div class="w-full h-full flex-shrink-0" data-carousel-item>
                    <img src="https://www.simbiotia.com/wp-content/uploads/diseno-de-clinicas-veterinarias.jpg" class="w-full h-full object-cover" alt="...">
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido sobre el carrusel (capa 1) -->
    <div class="relative z-20 flex flex-col items-center justify-center text-center px-4 py-16 md:py-24">
        <header class="bg-white bg-opacity-80 p-4 md:p-6 rounded-lg max-w-xs md:max-w-2xl">
            <h1 class="text-lg md:text-3xl font-bold text-gray-800">
                La <span class="text-blue-600">Clínica</span> Veterinaria <span class="text-blue-600">ODY</span> salvando <span class="text-blue-600">mascotas</span> en Tupiza
            </h1>
            <p class="mt-2 text-gray-700 text-sm md:text-base">
                En nuestra clínica tratamos a tu mascota y a tu familia, mejorando juntos para ofrecerte el mejor servicio veterinario.
            </p>
        </header>

        <div class="mt-6">
            <a href="{{ route('tickets.index') }}"
               class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                Reserva con Ticket virtual
            </a>
        </div>
    </div>

</div>

<!-- Sección de ubicación -->
<section class="map mt-10">
    <div class="container mx-auto rounded-xl px-4">
        <h1 class="text-center text-3xl md:text-4xl font-bold mb-6">Nuestra ubicación</h1>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d232.09493218510963!2d-65.71682141584255!3d-21.448146546448605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sbo!4v1741759036263!5m2!1ses!2sbo"
                width="100%" height="450" class="rounded-xl w-full"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
  <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Misión -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-blue-600">
                <h2 class="text-xl text-center font-semibold text-blue-700 mb-2">Misión</h2>
                <p class="text-gray-700 text-sm md:text-base leading-relaxed">
              Nuestra misión se trata de ofrecer servicios de alta calidad, enfocados en la salud y el bienestar de los animales.
                </p>
            </div>
    
            <!-- Visión -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-600">
                <h2 class="text-xl text-center font-semibold text-green-700 mb-2">Visión</h2>
                <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                    Ser una clínica veterinaria líder en Bolivia, reconocida por brindar la mejor atención médica y de alta calidad a las mascotas, promoviendo el bienestar animal con compromiso, calidez humana y excelencia profesional.
                </p>
            </div>
        </div>
    </div>
    </div>
   

<script>
  
    document.addEventListener("DOMContentLoaded", function () {
        document.body.classList.remove("opacity-0");

        let carouselIndex = 0;
        const images = document.querySelectorAll("[data-carousel-item]");
        const carousel = document.getElementById("carousel-images");

        function moveToNextImage() {
            if (carouselIndex === images.length - 1) {
                carousel.style.transition = 'none';
                carousel.style.transform = `translateX(-${carouselIndex * 100}%)`;
                setTimeout(() => {
                    carouselIndex = 0;
                    carousel.style.transition = 'transform 1s ease-in-out';
                    carousel.style.transform = `translateX(0%)`;
                }, 500);
            } else {
                carouselIndex++;
                carousel.style.transform = `translateX(-${carouselIndex * 100}%)`;
            }
        }
        setInterval(moveToNextImage, 3000);

       
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  crossorigin="anonymous">

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



</script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
</body>
</html>