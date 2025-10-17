<x-app-layout>
    <div class="container mx-auto bg-white rounded-xl shadow mt-8">
        <div class="p-8 text-gray-900">
            <h1 class="text-3xl font-extrabold mb-6 text-gray-800 flex items-center gap-2">
                <ion-icon name="trash-outline" class="text-red-500 w-7 h-7"></ion-icon>
                Registros Eliminados
            </h1>

            {{-- Mensajes de éxito o error --}}
            @if(session('mensaje'))
                <div id="mensaje" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('mensaje') }}
                </div>
            @endif
            @if(session('error'))
                <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Lista de accesos a eliminados --}}
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-3 mt-6">
                
                {{-- Usuarios eliminados --}}
                <a href="{{ route('users.trashed') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-blue-50 p-3 group">
                    <ion-icon name="people-outline" class="text-blue-600 w-10 h-10 mb-3 group-hover:text-blue-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-blue-800">Usuarios eliminados</span>
                </a>

                {{-- Productos eliminados --}}
                <a href="{{ route('productos.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-green-50 p-3 group">
                    <ion-icon name="bag-handle-outline" class="text-green-600 w-10 h-10 mb-3 group-hover:text-green-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-green-800">Productos eliminados</span>
                </a>

                {{-- Propietarios eliminados --}}
                <a href="{{ route('propietarios.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-purple-50 p-3 group">
                    <ion-icon name="man-outline" class="text-purple-600 w-10 h-10 mb-3 group-hover:text-purple-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-purple-800">Propietarios eliminados</span>
                </a>
                <a href="{{ route('categorias.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-yellow-50 p-3 group">
                    <ion-icon name="pricetag-outline" class="text-yellow-600 w-10 h-10 mb-3 group-hover:text-yellow-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-yellow-800">Categorías eliminadas</span>
                </a>
                <a href="{{ route('pacientes.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-red-50 p-3 group">
                    <ion-icon name="paw-outline" class="text-red-600 w-10 h-10 mb-3 group-hover:text-red-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-red-800">Mascotas eliminadas</span>
                </a>
               
                <a href="{{ route('historial.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-teal-50 p-3 group">
                    <ion-icon name="file-tray-full-outline" class="text-teal-600 w-10 h-10 mb-3 group-hover:text-teal-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-teal-800">Historiales eliminados</span>
                </a>
                
              
                <a href="{{ route('servicios.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-green-50 p-3 group">
                    <ion-icon name="construct-outline" class="text-green-600 w-10 h-10 mb-3 group-hover:text-green-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-green-800">Servicios eliminados</span>
                </a>
                <a href="{{ route('facturas.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-blue-50 p-3 group">
                    <ion-icon name="receipt-outline" class="text-blue-600 w-10 h-10 mb-3 group-hover:text-blue-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-blue-800">Ventas eliminadas</span>
                </a>
                <a href="{{ route('proveedores.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-yellow-50 p-3 group">
                    <ion-icon name="storefront-outline" class="text-yellow-600 w-10 h-10 mb-3 group-hover:text-yellow-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-yellow-800">Proveedores eliminados</span>
                </a>
                <a href="{{ route('inventario.deleted') }}"
                   class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-purple-50 p-3 group">
                    <ion-icon name="clipboard-outline" class="text-purple-600 w-10 h-10 mb-3 group-hover:text-purple-800 transition-all"></ion-icon>
                    <span class="text-gray-800 font-semibold group-hover:text-purple-800">Inventarios eliminados</span>
                </a>
                
                

            </div>
        </div>
    </div>
</x-app-layout>
