<!DOCTYPE html>
<html lang="es" class="h-full m-0">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Veterinaria ODDY</title>

        <!-- Fonts -->
        <link rel="icon" href="{{ asset("images/pawprint.png") }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
<meta name="theme-color" content="#2563eb">
<link rel="apple-touch-icon" href="{{ asset('images/images.png') }}">
    </head>
    <body class="font-sans overflow-x-hidden antialiased min-h-screen m-0 box-order bg-gray-100 dark:bg-black">
        <style>
            body {
    margin: 0;
    /* Light background */
}
            .dark {
                background-color: #000;
              
            }
           
        </style>
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
                              
                            @can("paciente.index")
                            <a href="{{ route('pacientes.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="paw-outline" class="h-5 w-5  dark:text-white"></ion-icon>
                                </div>
                                Mascotas
                            </a>
                            @endcan
                            @can("propietario.index")
                            <a href="{{ route('propietarios.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="man-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Propietarios
                            </a>
                            @endcan
                            @can("cita.index")
                            <a href="{{ route('citas.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="calendar-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Citas
                            </a>
                            @endcan
                            @can("ticket.inicio")
                            <a href="{{ route('tickets.inicio') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="ticket-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Tickets
                            </a>
                            @endcan
                            @can("categoria.index")
                            <a href="{{ route('categorias.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="pricetag-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                categorias
                            </a>   
                            @endcan
                            @can("producto.index")
                            <a href="{{ route('productos.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="bag-handle-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Productos
                            </a>
                            @endcan
                            @can("proveedor.index")
                            <a href="{{ route('proveedores.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="storefront-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Proveedores
                            </a>
                            @endcan
                            @can("factura.index")
                            <a href="{{ route('facturas.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="receipt-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Ventas
                            </a>
                            @endcan
                            @can("inventario.index")
                            <a href="{{ route('inventario.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="clipboard-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                                Inventario
                            </a>
                            @endcan
                            @can("servicio.index")
                            <a href="{{ route('servicios.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="construct-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                                Servicios
                            </a>
                            @endcan
                            @can("user.index")
                            <a href="{{ route('users.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="people-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                               
                                </div>
                               Usuarios
                            </a>
                            @endcan
                            @can("role.index")
                            <a href="{{ route('roles.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
                                <div class="grid place-items-center mr-4">
                                    <ion-icon name="cog-outline" class="h-5 w-5 dark:text-white"></ion-icon>
                                </div>
                                Roles
                            </a>
                            @endcan
                           <a href="{{ route('eliminado.index') }}" class="flex items-center w-full p-2 rounded-lg text-start leading-tight transition-all hover:bg-blue-50 hover:bg-opacity-80 focus:bg-blue-50 focus:bg-opacity-80 active:bg-gray-50 active:bg-opacity-80 hover:text-blue-900 focus:text-blue-900 active:text-blue-900 outline-none">
    <div class="grid place-items-center mr-4">
        <ion-icon name="trash-outline" class="h-5 w-5 dark:text-white"></ion-icon>
    </div>
    Eliminados
</a>

                        </nav>
                        
                </div>
                {{$slot}}
            </main>
        </div>
     
        <script type="module" src="/vendor/ionicons/ionicons.esm.js"></script>
        <script nomodule src="/vendor/ionicons/ionicons.js"></script>
        
    </body>
    <script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js')
    .then(() => console.log("✅ Service Worker registrado"))
    .catch(err => console.log("❌ Error en SW:", err));
}
</script>

</html>
