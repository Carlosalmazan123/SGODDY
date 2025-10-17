<x-app-layout>
    <div class="max-w-xl mx-auto container bg-white p-6 rounded-lg shadow-md sm:p-8">
        @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
<h1 class="text-3xl font-semibold mb-2">Crear historial</h1>
        <form action="{{ route('historial.store', $paciente->id) }}" method="POST" class="space-y-2">
            @csrf
            <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

            <div>
                <label for="anamnesis" class="block text-gray-700 font-semibold text-sm sm:text-base">Signos Clínicos<b class="text-red-600">*</b></label>
                <input type="text" name="anamnesis" value="{{ old('anamnesis') }}" required
                    class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>
            

            <div>
                <label for="diagnostico" class="block text-gray-700 font-semibold text-sm sm:text-base">Diagnóstico<b class="text-red-600">*</b></label>
                <textarea id="diagnostico" name="diagnostico" required
                    class="w-full  border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">{{ old('diagnostico') }}</textarea>
            </div>

            <div>
                <label for="examen" class="block text-gray-700 font-semibold text-sm sm:text-base">Examen<b class="text-red-600">*</b></label>
                <input id="examen" name="examen" value="{{ old('examen') }}"
                    class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="tratamiento" class="block text-gray-700 font-semibold text-sm sm:text-base">Tratamiento<b class="text-red-600">*</b></label>
                <input id="tratamiento" name="tratamiento[]" rows="3" required value="{{ old('tratamiento.0') }}"
                    class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="observaciones" class="block text-gray-700 font-semibold text-sm sm:text-base">Observaciones</label>
                <input id="observaciones" name="observaciones[]" placeholder="Opcional" rows="3" value="{{ old('observaciones.0') }}"
                    class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="fecha" class="block text-gray-700 font-semibold text-sm sm:text-base">Fecha<b class="text-red-600">*</b></label>
                <input type="date" id="fecha" name="fecha[]" required
                    class="w-full  border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                    value="{{ old('fecha.0', date('Y-m-d')) }}">
            </div>
            <button type="submit"
                class="w-full sm:w-auto py-2 px-6 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-200">
                Guardar Historial
            </button>
        </form>
    </div>
</x-app-layout>
