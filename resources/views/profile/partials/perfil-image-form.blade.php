<section>
    <style>
        .input-file {
    width: 50vw; /* Ocupa exactamente la mitad del ancho de la pantalla */
    max-width: 400px; /* Máximo 400px para evitar que sea muy grande en pantallas grandes */
    display: block;
    text-align: center;
    border: 1px solid #d1d5db; /* Gris claro */
    border-radius: 8px;
    cursor: pointer;
    background-color: #f9fafb; /* Gris muy claro */
    padding: 8px;
}
@media (prefers-color-scheme: dark) {
    .input-file {
        background-color: #374151; /* Gris oscuro */
        border: 1px solid #4b5563; /* Borde más oscuro */
        color: #d1d5db; /* Texto en gris claro */
    }
}
    </style>
    <form action="{{ route('profile.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <label for="image" class="text-lg font-medium text-gray-900 dark:text-gray-100">Foto de Perfil</label>
        <br>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Puedes actualizar la imagen de tu perfil en cualquier momento
        </p>
        <!-- Mostrar imagen actual -->
        <div class="mb-4 flex justify-center">
            @if(isset($authUser) && $authUser->image)
            <img src="{{ asset('storage/' . $authUser->image) }}" class="h-20 w-20 rounded-full object-cover mb-2">
        @else
            <img src="{{ asset('images/default-avatar.png') }}" class="h-20 w-20 rounded-full object-cover mb-2">
        @endif
        </div>
    
        <!-- Input para subir una nueva imagen -->
        <input type="file" name="image" aria-describedby="file_input_help" class="container input-file text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">

    <br>
        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Actualizar</button>    
    </form>
    
</section>