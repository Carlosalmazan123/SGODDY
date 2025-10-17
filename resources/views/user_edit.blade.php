<x-app-layout>
@if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
  
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-4xl mx-auto">
            <div class="p-6 text-gray-900 dark:text-gray-900">
                <h1 class="text-2xl text-center font-bold">EDITAR USUARIO</h1>
        
            <div class="mb-4">
                <form action="{{ route('users.update', [$user]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                   
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
                                <ion-icon id="toggle-icon" name="eye-off-outline" class="w-6 h-6"></ion-icon>
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
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.getElementById("toggle-icon");
    
            const isPassword = passwordField.type === "password";
            passwordField.type = isPassword ? "text" : "password";
            toggleIcon.setAttribute("name", isPassword ? "eye-outline" : "eye-off-outline");
        }
    </script>
    
</x-app-layout>
