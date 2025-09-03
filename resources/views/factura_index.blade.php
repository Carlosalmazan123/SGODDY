<x-app-layout>
    <div class="container mx-auto mt-4 p-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Ventas</h1>

        <div class="flex justify-between items-center mb-2">
            <a href="{{ route('facturas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-lg shadow">
                + Nueva Venta
            </a>
        </div>
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
        <div class="overflow-x-auto">
           <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Paciente</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                    <tr class="border-t">
                        <td class="px-6 py-2">{{ $factura->id }}</td>
                        <td class="px-6 py-2">
                            {{ optional($factura->paciente)->nombre ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-2">Bs. {{ number_format($factura->total, 2) }}</td>
                        <td class="px-6 py-2">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            
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
                                        onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                                        <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-2 text-center text-gray-500">No hay facturas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            <div class="mt-4">
                {{ $facturas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
