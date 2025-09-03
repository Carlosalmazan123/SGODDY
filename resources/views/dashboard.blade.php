<x-app-layout>
    <div class="flex w-full justify-center items-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-7xl px-4">

            <!-- Citas de hoy -->
            <a href="{{ route('citas.index') }}" class="block no-underline transform transition hover:scale-105">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg flex items-center justify-between hover:shadow-xl">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Citas de Hoy</h3>
                        <p class="text-4xl font-bold text-blue-600 mt-2">{{ $citasHoy }}</p>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
                        <ion-icon name="calendar-outline" class="text-blue-500 text-3xl"></ion-icon>
                    </div>
                </div>
            </a>

            <!-- Tickets de hoy -->
            <a href="{{ route('tickets.inicio') }}" class="block no-underline transform transition hover:scale-105">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg flex items-center justify-between hover:shadow-xl">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Tickets de Hoy</h3>
                        <p class="text-4xl font-bold text-green-600 mt-2">{{ $ticketsHoy }}</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 p-4 rounded-full">
                        <ion-icon name="ticket-outline" class="text-green-500 text-3xl"></ion-icon>
                    </div>
                </div>
            </a>

            <!-- Ventas de hoy -->
            <a href="{{ route('facturas.index') }}" class="block no-underline transform transition hover:scale-105">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg flex items-center justify-between hover:shadow-xl">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Ventas del Mes</h3>
                        <p class="text-4xl font-bold text-purple-600 mt-2">${{ number_format($ventasMes, 2, '.', ',') }}</p>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-full">
                        <ion-icon name="cash-outline" class="text-purple-500 text-3xl"></ion-icon>
                    </div>
                </div>
            </a>

        </div>
    </div>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</x-app-layout>
