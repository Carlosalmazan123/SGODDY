<script>
    function toggleDropdown() {
    let dropdown = document.getElementById("dropdownNotificaciones");
    dropdown.classList.toggle("hidden");
}

// Marcar una notificación como leída
function marcarLeida(id) {
        fetch(`/notificaciones/${id}/marcar-leida`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            // Elimina la notificación del DOM después de marcarla como leída
            document.getElementById(`notificacion-${id}`).remove();
        });
    }
// Marcar todas las notificaciones como leídas
function marcarTodasComoLeidas() {
    fetch(`/notificaciones/leer-todas`, {
        method: "PATCH",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Content-Type": "application/json",
        },
    })
    .then(() => location.reload());
}

</script>
<nav x-data="{ open: false }" class="bg-white dark:bg-black border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="absolute left-2 flex justify-center items-center w-full">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                
                
                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-4 overflow-x-auto scrollbar-hide">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
              </div>
            </div>
       

            <div class="flex items-center justify-between w-full sm:w-auto">
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                    <div class="relative">
                        <!-- Icono de la campanita -->
                        <button onclick="toggleDropdown()" class="relative focus:outline-none mr-4 dark:text-white">
                            <ion-icon name="notifications-outline" class="text-2xl"></ion-icon>
                    
                            <!-- Contador de notificaciones no leídas -->
                            @php
    $notificacionesCliente = auth()->user()->unreadNotifications->filter(function ($notificacion) {
        return isset($notificacion->data['user_id']) && 
               optional(\App\Models\User::find($notificacion->data['user_id']))->hasRole('cliente');
    });
@endphp

                        
                    
                            @if($notificacionesCliente->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full">
                                    {{ $notificacionesCliente->count() }}
                                </span>
                            @endif
                        </button>
                    
                        <!-- Dropdown de notificaciones -->
                        <div id="dropdownNotificaciones" class="hidden absolute text-black right-0 mt-2 w-72 bg-white dark:bg-gray-700 dark:text-white shadow-lg rounded-lg z-50">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">Notificaciones</h3>
                            </div>
                    
                            <div class="max-h-60 overflow-y-auto">
                                @forelse($notificacionesCliente as $notificacion)
                                <form action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}" method="POST" class="marcar-leida-form" data-notificacion-id="{{ $notificacion->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" onclick="marcarComoLeida('{{ $notificacion->id }}')">
                                        <button type="submit">
                                            <p class="text-xs">{{ $notificacion->data['mensaje'] }}</p>
                                            <p class="text-xs">{{ $notificacion->data['nombre_mascota'] }}</p>
                                            <small class="text-gray-500">{{ $notificacion->created_at->diffForHumans() }}</small>
                                        </button>
                                    </div>
                                </form>
                                @empty
                                    <p class="p-3 text-gray-500">No hay notificaciones</p>
                                @endforelse
                            </div>
                    
                            <!-- Botón para marcar todas como leídas -->
                            @if($notificacionesCliente->count() > 0)
                                <button onclick="marcarTodasComoLeidas()" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                    Marcar todas como leídas
                                </button>
                            @endif
                        </div>
                    </div>
                    

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-black hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                
                                @if(isset($authUser) && $authUser->image)
                                    <img src="{{ asset('storage/' . $authUser->image) }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" class="h-10 w-10 rounded-full object-cover">
                                @endif
    
                                
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                
                <!-- Hamburger -->
                <div class="absolute left-2 top-4 flex items-center sm:hidden">
                    <button @click="open = ! open" class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    
                </div>
                
                
                <button class="inline-flex items-center  border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-black hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 absolute right-0 top-0 mr-4 mt-4 sm:hidden">
                    @if(isset($authUser) && $authUser->image)
                        <img src="{{ asset('storage/' . $authUser->image) }}" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" class="h-10 w-10 rounded-full object-cover">
                    @endif
                </button>
            </div>
            <!-- Settings Dropdown -->
            
            
        </div>
    </div>
    
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <a href="{{ route('pacientes.index') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="paw-outline" class="h-5 w-5  "></ion-icon> Lista de pacientes</a>          
            <a href="{{ route('propietarios.index') }}" class="block border bg-white rounded px-3 py-2">
            <ion-icon name="man-outline" class="h-5 w-5  "></ion-icon>Propietarios</a>               
            <a href="{{ route('citas.index') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="calendar-outline" class="h-5 w-5  "></ion-icon>Citas</a>
            <a href="{{ route('tickets.inicio') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="ticket-outline" class="h-5 w-5   "></ion-icon>Tickets</a>
                <a href="{{ route('categorias.index') }}" class="block border bg-white rounded px-3 py-2">
            <ion-icon name="pricetag-outline" class="h-5 w-5   "></ion-icon>Categorías</a>
            <a href="{{ route('productos.index') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="bag-handle-outline" class="h-5 w-5   "></ion-icon>Productos</a>        
                <a href="{{ route('proveedores.index') }}" class="block border bg-white rounded px-3 py-2">
                    <ion-icon name="storefront-outline" class="h-5 w-5   "></ion-icon>Proveedores</a>
                    <a href="{{ route('facturas.index') }}" class="block border bg-white rounded px-3 py-2">
                        <ion-icon name="receipt-outline" class="h-5 w-5   "></ion-icon>Facturas</a>
                 <a href="{{ route('inventario.index') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="clipboard-outline"></ion-icon>Inventario</a>
            <a href="{{ route('servicios.index') }}" class="block border bg-white rounded px-3 py-2">
                <ion-icon name="construct-outline"></ion-icon>Servicios</a>
                <a href="{{ route('users.index') }}" class="block border bg-white rounded px-3 py-2">
                    <ion-icon name="people-outline"></ion-icon>Usuarios</a>    
            <x-responsive-nav-link :href="route('profile.edit')">
                <ion-icon name="person"></ion-icon>  {{ __('Perfil') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <ion-icon name="power"></ion-icon>  {{ __('Cerrar Sesion') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>

<!-- Estilos para la barra deslizable -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
