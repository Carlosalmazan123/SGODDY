<x-app-layout>
    

    
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 container p-4">
            
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Perfil') }}
                </h2>
            

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                
                @include('profile.partials.perfil-image-form')
                
            </div>

            <!-- Formulario para actualizar la información de perfil -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full sm:max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <!-- Formulario para cambiar la contraseña -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full sm:max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Formulario para eliminar el usuario -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full sm:max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    
</x-app-layout>
