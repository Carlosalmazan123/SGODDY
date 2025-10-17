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

        <form action="{{ route('historial.update', [$paciente->id, $historial->id]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="anamnesis" class="block text-gray-700 font-semibold text-sm sm:text-base">Signos Clínicos*</label>
                <input type="text" name="anamnesis" value="{{ old('anamnesis', $historial->anamnesis) }}" required
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="diagnostico" class="block text-gray-700 font-semibold text-sm sm:text-base">Diagnóstico*</label>
                <textarea id="diagnostico" name="diagnostico" required
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">{{ old('diagnostico', $historial->diagnostico) }}</textarea>
            </div>

            <div>
                <label for="examen" class="block text-gray-700 font-semibold text-sm sm:text-base">Examen*</label>
                <input id="examen" name="examen" value="{{ old('examen', $historial->examen) }}"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold text-sm sm:text-base">Tratamiento, Observaciones y Fecha*</label>
                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table id="treatment-table" class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-gray-700">Fecha</th>
                                <th class="border px-4 py-2 text-gray-700">Tratamiento*</th>
                                <th class="border px-4 py-2 text-gray-700">Observaciones*</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(old('fecha', $historial->fecha ?? []) as $index => $value)
                            <tr class="border border-gray-300 text-center">
                                <td class="p-2 border border-gray-300">
                                    <input type="date" name="fecha[]" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                                        value="{{ old('fecha.' . $index, $value) }}">
                                </td>
                                <td class="p-2 border border-gray-300">
                                    <input type="text" name="tratamiento[]" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                                        value="{{ old('tratamiento.' . $index, $historial->tratamiento[$index] ?? '') }}">
                                </td>
                                <td class="p-2 border border-gray-300">
                                    <input type="text" name="observaciones[]"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"
                                        value="{{ old('observaciones.' . $index, $historial->observaciones[$index] ?? '') }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" id="add-row" class="mt-2 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-200">
                    Agregar Fila
                </button>
                <button type="button" id="remove-row" class="mt-2 ml-4 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition duration-200">
                    Eliminar Última Fila
                </button>
            </div>

            <button type="submit"
                class="w-full sm:w-auto py-2 px-6 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">
                Actualizar Historial
            </button>
        </form>
    </div>

    <script>
        document.getElementById('add-row').addEventListener('click', function() {
            var existingRows = document.querySelectorAll('#treatment-table tbody tr');
    
            // Verificar si ya hay 20 filas
            if (existingRows.length < 20) {
                // Crear una nueva fila
                var newRow = document.createElement('tr');
                newRow.classList.add('border', 'border-gray-300', 'text-center');
    
                newRow.innerHTML = `
                    <td class="p-2 border border-gray-300">
                        <input type="date" name="fecha[]" required class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
                    </td>
                    <td class="p-2 border border-gray-300">
                        <input type="text" name="tratamiento[]" required class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
                    </td>
                    <td class="p-2 border border-gray-300">
                        <input type="text" name="observaciones[]" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
                    </td>
                `;
    
                // Agregar la nueva fila al cuerpo de la tabla
                document.getElementById('treatment-table').querySelector('tbody').appendChild(newRow);
            } else {
                alert("Llegaste al número máximo de filas");
            }
        });
        document.getElementById('remove-row').addEventListener('click', function() {
        var existingRows = document.querySelectorAll('#treatment-table tbody tr');
        
        // Eliminar la última fila si hay filas en la tabla
        if (existingRows.length > 0) {
            existingRows[existingRows.length - 1].remove();
        } else {
            alert("No hay filas para eliminar");
        }
    });
        // Función para obtener el valor anterior (en caso de querer mantener el valor antiguo en la fila agregada)
        function getOldValue(name, index) {
            var oldValue = old(name); // Usar old() si estás usando Laravel o pasarlo desde el backend
            return oldValue ? oldValue[index] : '';
        }
    </script>
    
</x-app-layout>
