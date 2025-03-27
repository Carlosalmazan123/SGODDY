<x-app-layout>
@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl text-center font-bold">EDITAR USUARIO</h1>
        <div class="w-100 flex items-end justify-end" class="mx-9">
        </div>
            <div class="mb-4">
                <form action="{{ route('users.update', [$user]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Imagen de perfil</label>
                        <input type="file" name="image" class="mt-1 p-2 border border-gray-300 rounded w-full">
                    
                        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="text" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600 focus:outline-none">
                                <img id="toggle-icon" src="{{ asset('images/ojito cerrado.svg') }}" alt="Mostrar" class="w-6 h-6 transition-all duration-500">
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar</button>
                        <a href="{{ route('users.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                document.querySelector("button[onclick='togglePasswordVisibility()']").textContent = "Ocultar";
            } else {
                passwordField.type = "password";
                document.querySelector("button[onclick='togglePasswordVisibility()']").textContent = "Mostrar";
            }
        }
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
