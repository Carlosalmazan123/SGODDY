<x-app-layout>

<div class="container">
    <h1 class="text-center mb-4">{{ $producto->nombre }}</h1>
    <div class="card">
        <div class="card-body">
            <h4>Descripción:</h4>
            <p>{{ $producto->descripcion }}</p>
            
            <h4>Categoría:</h4>
            <p>{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</p>
            
            <h4>Precio:</h4>
            <p>${{ number_format($producto->precio, 2) }}</p>
            
            <h4>Stock:</h4>
            <p>{{ $producto->stock }}</p>
            
            <h4>Unidad:</h4>
            <p>{{ $producto->unidad_medida }}</p>
        </div>
    </div>
</div>
</x-app-layout>