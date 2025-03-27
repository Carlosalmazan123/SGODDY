<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-orange-500 border border-gray-400 text-white px-6 py-4 border-rounded">
                <h2 class="text-xl font-semibold">Permisos</h2>
            </div>
            <div class="p-6 border border-gray-400 border-t-transparent">
                <form action="{{ route("roles.permissions.update", [$role]) }}" method="post">
                    @csrf
                    @method('PUT')
    
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                        <div class="mb-3">
                            <label for="{{ $permission->name }}" class="">{{ $permission->name }}</label>
                            <input type="checkbox" value="{{ $permission->name }}" name="permissions[]" id="{{ $permission->name }}"
                                @foreach($role->getPermissionNames() as $rolePermission)
                                    {{ $rolePermission == $permission->name ? "checked" : "" }}
                                @endforeach
                                class="form-checkbox h-5 w-5 text-blue-600">
                        </div>
                        @endforeach
                    </div>
    
                    <div class="text-center mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded mr-2">Guardar</button>
                        <a href="{{ route("roles.index") }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Cancelar</a>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
