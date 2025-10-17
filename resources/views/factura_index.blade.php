<x-app-layout>
    <div class="container mx-auto mt-4 p-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Ventas</h1>

        <div class="flex justify-between items-center mb-2">
            <a href="{{ route('facturas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-lg shadow">
                + Nueva Venta
            </a>
            
        </div>
        <!-- Botón que abre el modal -->
<button id="btnAbrirModalReporte"
    class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded inline-flex items-center">
    <ion-icon name="document-text-outline" class="mr-2 text-xl"></ion-icon>
    Generar Reporte Ventas
</button>

        @if (session('success'))
        <div id="success-message" class="mt-3 p-2 bg-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
    
        <script>
            // Desaparecer el mensaje después de 1 segundo
            setTimeout(function() {
                let message = document.getElementById('success-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 1000); // 1000 ms = 1 segundo
        </script>
    @endif
         <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Usuario</th>
                    <th class="px-4 py-2 border">Total</th>
                    <th class="px-4 py-2 border">Fecha</th>
                    <th class="px-4 py-2 border text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                    <tr class="text-center border-t hover:bg-gray-50 transition-all">
                        <td class="border px-4 py-2">{{ $factura->id }}</td>
                        <td class="border px-4 py-2">
                            {{ $factura->user->name }}
                        </td>
                        <td class="border px-4 py-2">Bs. {{ number_format($factura->total, 2) }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 flex ">
                            <div class="flex  justify-center space-x-2">
                                 <a href="{{ route('facturas.pdf', $factura->id) }}"
                                    target="_blank"
                                    class="text-green-500 hover:text-green-600  py-1 rounded-lg ">
                                    <ion-icon name="reader-outline" class="h-6 w-6"></ion-icon>
                                </a>
                           
                                @can("factura.edit")
                                <a href="{{ route('facturas.edit', $factura->id) }}"
                                    class="text-blue-500 hover:text-blue-600 py-1 rounded-lg ">
                                    <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                </a>
                                @endcan
                                @can("factura.delete")
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-600 py-1 rounded-lg "
                                        onclick="return confirm('¿Estás seguro de eliminar esta venta?')">
                                        <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                            </div>
                               
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class=" rounded-lg text-center border-gray-500 border px-4 py-2 text-gray-500">No hay recibos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
  </div>
    </div>
            <div class="mt-4">
                {{ $facturas->links() }}
            </div>
    </div>
    <!-- Modal para seleccionar fecha o rango -->
<div id="modal-reporte-ventas" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Generar reporte de ventas</h3>

        <form action="{{ route('ventas.reporte.pdf') }}" method="GET" target="_blank">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha desde</label>
                    <input type="date" id="fecha_desde" name="fecha_desde" class="mt-1 block w-full rounded border-gray-300 p-2" />
                </div>
                <div>
                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha hasta</label>
                    <input type="date" id="fecha_hasta" name="fecha_hasta" class="mt-1 block w-full rounded border-gray-300 p-2" />
                </div>
            </div>

            <p class="text-sm text-gray-500 mt-2">Si no ingresa fechas, se generará el reporte de hoy.</p>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" id="btnCerrarModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Generar PDF</button>
            </div>
        </form>
    </div>
</div>

<script>
    const btnAbrir = document.getElementById('btnAbrirModalReporte');
    const modal = document.getElementById('modal-reporte-ventas');
    const btnCerrar = document.getElementById('btnCerrarModal');

    btnAbrir.addEventListener('click', () => modal.classList.remove('hidden'));
    btnCerrar.addEventListener('click', () => modal.classList.add('hidden'));

    // Cerrar modal con ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') modal.classList.add('hidden');
    });
</script>

</x-app-layout>
