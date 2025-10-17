<x-app-layout>

    <div class="container mx-auto  bg-white rounded-xl shadow mt-4 ">
                <div class="p-6 text-gray-900 ">
       <div class="container mx-auto  ">
        <h1 class="text-2xl font-bold mb-4">Historiales Clínicos Eliminados</h1>
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
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8"> 
            {{-- Botones superiores --}}
            <div class="flex  flex-col sm:flex-row justify-between mb-4 gap-3">
                                <a href="{{ route('eliminado.index') }}"
                                    class="flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all duration-200">
                                    <ion-icon name="arrow-back-outline" class="text-lg mr-2"></ion-icon> Volver
                                </a>
                                <form action="{{ route('historial.forceDeleteAll') }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar permanentemente todos los historiales eliminados?')"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all duration-200">
                                        <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                        Eliminar todos
                                    </button>
                                </form>

                      

                            </div>

            {{-- Tabla responsiva --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 border">ID</th>
                                <th class="px-4 py-3 border">Paciente</th>
                                <th class="px-4 py-3 border">Descripción</th>
                                <th class="px-4 py-3 border">Eliminado el</th>
                                <th class="px-4 py-3 border text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deletedHistoriales as $historial)
                                <tr class="text-center border-t hover:bg-gray-50 transition-all">
                                    <td class="px-4 py-2">{{ $historial->id }}</td>
                                    <td class="px-4 py-2">{{ $historial->paciente->nombre }} {{ $historial->paciente->apellido }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($historial->anamnesis, 50) }}</td>
                                    <td class="px-4 py-2 text-gray-500">
                                        {{ $historial->deleted_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Restaurar -->
                                            <form action="{{ route('historial.restore', $historial->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                    Restaurar
                                                </button>
                                            </form>
                                            <!-- Eliminar definitivamente -->
                                            <form action="{{ route('historial.forceDelete', $historial->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar este historial clínico permanentemente? Esta acción no se puede deshacer.')"
                                                    class="flex items-center gap-1 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                                <ion-icon name="trash-outline" class="w-5 h-5"></ion-icon>
                                                Eliminar
                                            </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>  
                            @empty
                                <tr>
                                   <td colspan="5" class="rounded-lg text-center border-gray-500 px-4 py-2 text-gray-500"><ion-icon name="alert-circle-outline" class="text-gray-400 text-2xl"></ion-icon>No hay historiales clínicos eliminados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
            </div>
            {{-- Paginación --}}
            <div class="mt-6">
                {{ $deletedHistoriales->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>