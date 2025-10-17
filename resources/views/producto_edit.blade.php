<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Producto</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-700 text-red-800 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Checkbox vencimiento -->
            <div class="flex items-center space-x-2 mb-4">
                <input type="checkbox" name="check" id="chk_vencimiento"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded"
                       {{ old('check', $producto->check) ? 'checked' : '' }}>
                <label for="chk_vencimiento" class="text-gray-700">¿El producto tiene fecha de vencimiento?</label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700">Nombre*</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-gray-700">Categoría*</label>
                    <select name="categoria_id" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Precio -->
                 <div>
                    <label class="block text-gray-700">Precio de compra*</label>
                    <input type="number" name="precio_compra" step="0.01" value="{{ old('precio_compra', $producto->precio_compra) }}"
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700">Precio*</label>
                    <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio) }}"
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Fecha de vencimiento -->
                <div id="div_vencimiento" class="{{ old('check', $producto->check) ? '' : 'hidden' }}">
                    <label class="block text-gray-700">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento) }}"
                           class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Unidad -->
                <div>
                    <label class="block text-gray-700">Unidad*</label>
                    <select name="unidad" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccione una opción</option>
                        <option value="kilo" {{ $producto->unidad == 'kilo' ? 'selected' : '' }}>kilo</option>
                        <option value="litro" {{ $producto->unidad == 'litro' ? 'selected' : '' }}>litro</option>
                        <option value="metro" {{ $producto->unidad == 'metro' ? 'selected' : '' }}>metro</option>
                        <option value="unidad" {{ $producto->unidad == 'unidad' ? 'selected' : '' }}>unidad</option>
                        <option value="tableta" {{ $producto->unidad == 'tableta' ? 'selected' : '' }}>tableta</option>
                        <option value="capsula" {{ $producto->unidad == 'capsula' ? 'selected' : '' }}>capsula</option>
                        <option value="dosis" {{ $producto->unidad == 'dosis' ? 'selected' : '' }}>dosis</option>
                        <option value="otro" {{ $producto->unidad == 'otro' ? 'selected' : '' }}>otro</option>
                    </select>
                </div>

                <!-- Proveedor -->
                <div>
                    <label class="block text-gray-700">Proveedor*</label>
                    <select name="proveedor_id" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-gray-700">Imagen</label>
                    <input type="file" name="imagen" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    @if($producto->imagen)
                        <p class="mt-2 text-sm text-gray-500">Imagen actual:</p>
                        <img src="{{ asset('storage/'.$producto->imagen) }}" alt="Imagen Producto" class="h-20 mt-1 rounded-md border">
                    @endif
                </div>
            </div>

            <!-- Botón -->
            <button type="submit" class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Actualizar Producto
            </button>
        </form>
    </div>

    <!-- Script vencimiento -->
    <script>
        document.getElementById('chk_vencimiento').addEventListener('change', function () {
            const divVencimiento = document.getElementById('div_vencimiento');
            divVencimiento.classList.toggle('hidden', !this.checked);
        });
    </script>
</x-app-layout>
