<x-app-layout>
    <div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Facturas</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('facturas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Nueva Factura
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse bg-gray-100 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="p-3 text-left">Paciente</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Método de Pago</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($facturas as $factura)
                        <tr class="hover:bg-gray-100">
                            <td class="p-3">{{ $factura->paciente->nombre }}</td>
                            <td class="p-3 font-semibold text-green-600">${{ number_format($factura->total, 2) }}</td>
                            <td class="p-3">{{ $factura->metodo_pago }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded-lg text-white text-sm
                                    {{ $factura->estado == 'Pagado' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                    {{ $factura->estado }}
                                </span>
                            </td>
                            <td class="p-3 flex justify-center space-x-2">
                                <a href="{{ route('facturas.edit', $factura->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow">
                                    Editar
                                </a>
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow"
                                        onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
