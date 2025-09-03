<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

<meta name="theme-color" content="#2563eb">
<link rel="apple-touch-icon" href="{{ asset('images/images.png') }}">
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
   
    {{ $slot }}
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