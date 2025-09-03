<!DOCTYPE html>
<html lang="es" class="h-full" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Veterinaria ODDY</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset("images/pawprint.png") }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script type="module" src="/vendor/ionicons/ionicons.esm.js"></script>
        <script nomodule src="/vendor/ionicons/ionicons.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
               <style>[x-cloak] { display: none !important; }</style>
           <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
                   <link rel="manifest" href="{{ url('/manifest.json') }}">
<meta name="theme-color" content="#2563eb">
<link rel="apple-touch-icon" href="{{ asset('images/images.png') }}">
    </head>
    <body class="font-sans m-0 box-order text-gray-900 antialiased dark:bg-black dark:text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-black">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
          
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-blue-500  shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
       
    </body>
    <script>
        if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js')
    .then(() => console.log("✅ Service Worker registrado"))
    .catch(err => console.log("❌ Error en SW:", err));
}
    </script>
</html>
