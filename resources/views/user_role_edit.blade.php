<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-7">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-gray-400 text-black px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">ROLES</h2>
            </div>
            <div class="p-6">
                <form action="{{ route("users.roles.update", [$user]) }}" method="post">
                    @csrf
                    @method('PUT')
                    @foreach($roles as $role)
                    <div class="mb-3">
                        <label for="{{ $role->name }}" class="inline-block">{{ $role->name }}</label>
                        <input type="checkbox" value="{{ $role->name }}" name="roles[]" id="{{ $role->name }}"
                        @foreach($user->getRoleNames() as $userRole)
                            {{ $role->name == $userRole ? "checked" : "" }}
                        @endforeach
                        class="form-checkbox h-5 w-5 text-blue-600">
                    </div>
                    @endforeach
                    <div class="text-center mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2">Guardar</button>
                        <a href="{{ route("users.index") }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>