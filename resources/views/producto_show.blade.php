<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detalle del Producto</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información principal -->
            <div class="space-y-4">
                <p>
                    <strong class="text-gray-700">Nombre:</strong> 
                    <span class="text-gray-900">{{ $producto->nombre }}</span>
                </p>
                <p>
                    <strong class="text-gray-700">Categoría:</strong> 
                    <span class="text-gray-900">{{ $producto->categoria->nombre ?? '-' }}</span>
                </p>
                <p>
                    <strong class="text-gray-700">Precio:</strong> 
                    <span class="text-gray-900">Bs. {{ number_format($producto->precio, 2) }}</span>
                </p>
                <p>
                    <strong class="text-gray-700">Unidad:</strong> 
                    <span class="text-gray-900">{{ ucfirst($producto->unidad) }}</span>
                </p>

                <p>
                    <strong class="text-gray-700">Proveedor:</strong> 
                    <span class="text-gray-900">{{ $producto->proveedor->nombre ?? 'No asignado' }}</span>
                </p>

                <p>
                    <strong class="text-gray-700">Fecha de vencimiento:</strong> 
                    <span class="text-gray-900">
                        @if($producto->check && $producto->fecha_vencimiento)
                            {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}
                        @else
                            No aplica
                        @endif
                    </span>
                </p>

                <p>
                    <strong class="text-gray-700">Registrado el:</strong> 
                    <span class="text-gray-900">{{ $producto->created_at->format('d/m/Y H:i') }}</span>
                </p>
            </div>

            <!-- Imagen -->
            <div class="flex flex-col items-center justify-center">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto"
                         class="rounded-md shadow-md w-64 h-64 object-cover">
                @else
                    <div class="w-64 h-64 flex items-center justify-center bg-gray-100 rounded-md border">
                        <span class="text-gray-500">Sin imagen</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('productos.index') }}"
               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">
                Volver
            </a>
            <a href="{{ route('productos.edit', $producto->id) }}"
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">
                Editar
            </a>
            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
