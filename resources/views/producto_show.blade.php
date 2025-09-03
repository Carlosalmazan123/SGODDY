<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-center mb-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $producto->nombre }}</h1>
        <div class="card bg-white dark:bg-white rounded-lg shadow-md">
            <div class="card-body p-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-black">Descripción:</h4>
                <p class="text-gray-700 dark:text-black">{{ $producto->descripcion }}</p>
                
                <h4 class="text-lg font-semibold text-gray-900 dark:text-black mt-4">Categoría:</h4>
                <p class="text-gray-700 dark:text-black">{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</p>
                
                <h4 class="text-lg font-semibold text-gray-900 dark:text-black mt-4">Precio:</h4>
                <p class="text-gray-700 dark:text-black">${{ number_format($producto->precio, 2) }}</p>
                
                <h4 class="text-lg font-semibold text-gray-900 dark:text-black mt-4">Stock:</h4>
                <p class="text-gray-700 dark:text-black">{{ $producto->stock }}</p>
                
                <h4 class="text-lg font-semibold text-gray-900 dark:text-black mt-4">Unidad:</h4>
                <p class="text-gray-700 dark:text-black">{{ $producto->unidad_medida }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
