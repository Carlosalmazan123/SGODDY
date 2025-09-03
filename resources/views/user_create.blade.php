<x-app-layout>
    

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl text-center font-bold">NUEVO USUARIO</h1>
                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="list-disc">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="flex justify-center mt-4">
                        <button type="button" id="togglePropietario" class="px-4 py-2 bg-green-500 text-white rounded">
                            Seleccionar Propietario
                        </button>
                    </div>

                    <!-- Select de propietarios (oculto por defecto) -->
                    <div id="propietarioSelectDiv" class="hidden mt-4">
                        <label for="propietario_id" class="block font-medium text-[#07074D]">Seleccionar Propietario</label>
                        <select id="propietario_id" class="w-full border-gray-300 rounded-md">
                            <option value="">Seleccione un propietario</option>
                            @foreach ($propietarios as $propietario)
                                <option value="{{ $propietario->id }}" data-nombre="{{ $propietario->nombre }}" data-apellido="{{ $propietario->apellido }}">
                                    {{ $propietario->nombre }} {{ $propietario->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Formulario de usuario -->
                    <div class="flex items-center justify-center p-12">
                        <div class="mx-auto w-full max-w-[550px]">
                            <form action="{{ route('users.store') }}" method="post">
                                @csrf
                                <div class="mb-5">
                                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Nombre</label>
                                    <input type="text" value="{{ old('name') }}" name="name" id="name"
                                           placeholder="Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                                </div>
                                <div class="mb-5">
                                    <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">Correo</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                           placeholder="Correo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                                </div>
                                <div class="mb-5">
                                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" value="{{ old('password') }}"
                                               class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 py-3 text-gray-600 focus:outline-none">
                                            <img id="toggle-icon" src="{{ asset('images/ojito cerrado.svg') }}" alt="Mostrar" class="w-6 h-6 transition-all duration-500">
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center text-center">
                                    <button type="submit" class="hover:shadow-form rounded-md bg-blue-500 hover:bg-blue-600 py-3 px-5 text-base font-semibold text-white outline-none">
                                        Guardar
                                    </button>
                                    <a href="{{ route('users.index') }}" class="ml-2 bg-red-600 font-semibold p-3 rounded-lg text-white">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('togglePropietario').addEventListener('click', function () {
            let propietarioSelectDiv = document.getElementById('propietarioSelectDiv');
            propietarioSelectDiv.classList.toggle('hidden');
        });

        document.getElementById('propietario_id').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            let nombre = selectedOption.getAttribute('data-nombre');
            let apellido = selectedOption.getAttribute('data-apellido');

            if (nombre && apellido) {
                document.getElementById('name').value = nombre + ' ' + apellido;
            }
        });

        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var passwordFieldType = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = passwordFieldType;

            var toggleIcon = document.getElementById('toggle-icon');
            var currentSrc = toggleIcon.getAttribute('src');

            if (currentSrc.includes('ojito cerrado.svg')) {
                toggleIcon.setAttribute('src', '{{ asset('images/ojito abierto.svg') }}');
                toggleIcon.setAttribute('alt', 'Ocultar');
            } else {
                toggleIcon.setAttribute('src', '{{ asset('images/ojito cerrado.svg') }}');
                toggleIcon.setAttribute('alt', 'Mostrar');
            }
        }
    </script>
</x-app-layout>
