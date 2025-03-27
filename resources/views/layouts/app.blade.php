<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-100 dark:bg-black">
        @if(Auth::user()->hasRole('cliente'))
    @php
        abort(403, 'No tienes permiso para acceder a esta pagina :(');
    @endphp
@endif
        <div class="min-h-screen ">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-black shadow ">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main >
                <div class="flex h-[calc(100vh-2rem)]">
                    <div class="relative flex-col bg-clip-border rounded-xl bg-gray-300 dark:bg-gray-800 text-black dark:text-white h-[calc(100vh-2rem)] w-full max-w-[16rem] p-4 shadow-xl shadow-blue-gray-900/5 lg:block hidden">
                        
                        <nav class="flex flex-col gap-1 min-w-[240px] p-2 font-sans text-base font-normal dark:text-white">
                            <a href="{{ route('pacientes.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="paw-outline" class="h-5 w-5  dark:text-white"></ion-icon>
                                </div>
                                Mascotas
                            </a>
                            
                            <a href="{{ route('propietarios.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="man-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Propietarios
                            </a>
                            <a href="{{ route('citas.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="calendar-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Citas
                            </a>
                            <a href="{{ route('tickets.inicio') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="ticket-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Tickets
                            </a>
                            
                            <a href="{{ route('categorias.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="pricetag-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                categorias
                            </a>
                            <a href="{{ route('productos.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="bag-handle-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Productos
                            </a>
                            <a href="{{ route('proveedores.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="storefront-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Proveedores
                            </a>
                            <a href="{{ route('facturas.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="receipt-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Facturas
                            </a>
                            <a href="{{ route('inventario.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="clipboard-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                                Inventario
                            </a>
                            <a href="{{ route('servicios.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="construct-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                                Servicios
                            </a>
                            <a href="{{ route('users.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="people-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                               Usuarios
                            </a>
                            <a href="{{ route('roles.index') }}" class="flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="cog-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Roles
                            </a>
                        </nav>
                        
                </div>
                {{$slot}}
            </main>
        </div>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
