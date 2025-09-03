<x-app-layout>
    <div class="max-w-xl mx-auto container bg-white p-6 rounded-lg shadow-md sm:p-8">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('historial.store', $paciente->id) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

            <div>
                <label for="anamnesis" class="block text-gray-700 font-semibold text-sm sm:text-base">Signos Clínicos</label>
                <input type="text" name="anamnesis" value="{{ old('anamnesis') }}" required
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>
            

            <div>
                <label for="diagnostico" class="block text-gray-700 font-semibold text-sm sm:text-base">Diagnóstico</label>
                <textarea id="diagnostico" name="diagnostico" required
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">{{ old('diagnostico') }}</textarea>
            </div>

            <div>
                <label for="examen" class="block text-gray-700 font-semibold text-sm sm:text-base">Examen</label>
                <input id="examen" name="examen" value="{{ old('examen') }}"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="tratamiento" class="block text-gray-700 font-semibold text-sm sm:text-base">Tratamiento</label>
                <input id="tratamiento" name="tratamiento[]" rows="3" required value="{{ old('tratamiento.0') }}"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="observaciones" class="block text-gray-700 font-semibold text-sm sm:text-base">Observaciones</label>
                <input id="observaciones" name="observaciones[]" rows="3" value="{{ old('observaciones.0') }}"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="fecha" class="block text-gray-700 font-semibold text-sm sm:text-base">Fecha</label>
                <input type="date" id="fecha" name="fecha[]" required
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                    value="{{ old('fecha.0', date('Y-m-d')) }}">
            </div>

            <button type="submit"
                class="w-full sm:w-auto py-2 px-6 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-200">
                Guardar Historial
            </button>
        </form>
    </div>
</x-app-layout>
