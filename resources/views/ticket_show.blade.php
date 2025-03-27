<x-app-layout>
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 text-center mt-4">
        <h2 class="text-2xl font-bold mb-4">Ticket Virtual</h2>
        <p class="text-lg">Código: <span class="font-bold text-blue-600">{{ $ticket->codigo }}</span></p>
        <p class="text-lg">Hora de Generación: <span class="font-semibold">{{ $ticket->hora_generacion }}</span></p>
        <p class="text-lg">Hora Estimada de Retorno: <span class="font-semibold text-red-500">{{ $ticket->hora_estimacion_retorno }}</span></p>
        <p class="text-lg font-bold text-yellow-500 mt-4">Estado: {{ $ticket->estado }}</p>
        <a href="{{ route('tickets.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-500 text-white rounded">Volver</a>
    </div>
</x-app-layout>
