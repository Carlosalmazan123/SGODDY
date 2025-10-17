<x-app-layout>

    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">VENTAS ELIMINADAS</h1>
        @if (session('mensaje'))
            <div id="mensaje" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                {{ session('mensaje') }}
            </div>
        @endif
        @if (session('error'))
            <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
            <a href="{{ route('eliminado.index') }}"
                class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                <ion-icon name="arrow-back-outline" class="text-lg mr-2"></ion-icon> Volver
            </a>
            <form action="{{ route('facturas.forceDeleteAll') }}" method="POST"
                onsubmit="return confirm('¿Eliminar permanentemente todas las ventas eliminadas?')"
                class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                    <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                    Eliminar todos
                </button>
            </form>

            <a href="{{ route('facturas.index') }}"
                class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                <ion-icon name="arrow-forward-outline" class="text-lg mr-2"></ion-icon> Ir a
                Ventas
            </a>
        </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border">ID</th>

                    <th class="px-4 py-3 border">Fecha</th>
                    <th class="px-4 py-3 border">Total</th>
                    <th class="px-4 py-3 border">Eliminado el</th>
                    <th class="px-4 py-3 border text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deletedFacturas as $factura)
                    <tr class="text-center border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $factura->id }}</td>


                        <td class="px-4 py-2">{{ $factura->fecha->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ number_format($factura->total, 2) }}</td>
                        <td class="px-4 py-2 text-gray-500">{{ $factura->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                <form action="{{ route('facturas.restore', $factura->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                        Restaurar
                                    </button>
                                </form>
                                <form action="{{ route('facturas.forceDelete', $factura->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('¿Eliminar permanentemente esta factura?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="rounded-lg text-center border-gray-500 px-4 py-2 text-gray-500">
                            <ion-icon name="alert-circle-outline" class="text-gray-400 text-2xl"></ion-icon>No hay
                            facturas eliminadas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $deletedFacturas->links() }}
        </div>
    </div>
</x-app-layout>
