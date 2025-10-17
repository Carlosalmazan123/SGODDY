<x-app-layout>
    <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
        <div class="p-6 text-gray-900 ">
            <div class="container mx-auto  ">
                <h1 class="text-2xl font-bold mb-4">PRODUCTOS ELIMINADOS</h1>
                <div class="flex flex-col ">
                    @if (session('mensaje'))
                        <div id="mensaje"
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div id="error"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="py-6">
                        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                            {{-- Botones superiores --}}
                            <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
                                <a href="{{ route('eliminado.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-back-outline" class=" text-lg mr-2"></ion-icon> Volver
                                </a>
                                <form action="{{ route('productos.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los productos eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>
                                <a href="{{ route('productos.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon>
                                    Ir a productos
                                </a>

                            </div>

                            {{-- Tabla responsiva --}}
                            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm text-gray-700">
                                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                            <tr>
                                                <th class="px-4 py-3 border">ID</th>
                                                <th class="px-4 py-3 border">Nombre</th>
                                                <th class="px-4 py-3 border">Precio</th>
                                                <th class="px-4 py-3 border">Stock</th>
                                                <th class="px-4 py-3 border">Eliminado el</th>
                                                <th class="px-4 py-3 border text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($deletedProducts as $product)
                                                <tr class="text-center border-t hover:bg-gray-50 transition-all">
                                                    <td class="px-4 py-2">{{ $product->id }}</td>
                                                    <td class="px-4 py-2">{{ $product->nombre }}</td>
                                                    <td class="px-4 py-2">{{ number_format($product->precio, 2) }}</td>
                                                    <td class="px-4 py-2">{{ $product->stock }}</td>
                                                    <td class="px-4 py-2 text-gray-500">
                                                        {{ $product->deleted_at->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-2 flex justify-center flex-wrap gap-2">
                                                        <form action="{{ route('productos.restore', $product->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="flex items-center gap-1 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition-all">
                                                                <ion-icon name="refresh-outline"
                                                                    class="w-4 h-4"></ion-icon>
                                                                Restaurar
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('productos.forceDelete', $product->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('¿Eliminar permanentemente este producto?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="flex items-center gap-1 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition-all">
                                                                <ion-icon name="trash-bin-outline"
                                                                    class="w-4 h-4"></ion-icon>
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6"
                                                        class="rounded-lg border-gray-500 px-4 py-2 text-center text-gray-500">
                                                        <ion-icon name="alert-circle-outline"
                                                            class="text-gray-400 text-2xl"></ion-icon>No hay productos
                                                        eliminados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Paginación --}}
                            <div class="mt-6">
                                {{ $deletedProducts->links() }}
                            </div>
                        </div>
                    </div>
</x-app-layout>
