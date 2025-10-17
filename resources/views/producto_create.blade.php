<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Producto</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-700 text-red-800 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 <!-- Checkbox para vencimiento -->
                
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center space-x-2">
                    <input type="checkbox" name="check" id="chk_vencimiento" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <label for="chk_vencimiento" class="text-gray-700">¿El producto tiene fecha de vencimiento?</label>
                </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700">Nombre*</label>
                    <input type="text" name="nombre" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-gray-700">Categoría*</label>
                    <select name="categoria_id" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Precio -->
                 <div>
                    <label class="block text-gray-700">Precio de compra*</label>
                    <input type="number" name="precio_compra" step="0.01" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700">Precio de venta*</label>
                    <input type="number" name="precio" step="0.01" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

               

                <!-- Fecha de vencimiento (oculto por defecto) -->
                <div id="div_vencimiento" class="hidden">
                    <label class="block text-gray-700">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Unidad -->
                <div>
                    <label class="block text-gray-700">Unidad*</label>
                    <select name="unidad" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccione una opción</option>
                        <option value="kilo">kilo</option>
                        <option value="litro">litro</option>
                        <option value="metro">metro</option>
                        <option value="unidad">unidad</option>
                        <option value="tableta">tableta</option>
                        <option value="capsula">capsula</option>
                        <option value="dosis">dosis</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <!-- Proveedor -->
                <div>
                    <label class="block text-gray-700">Proveedor*</label>
                    <select name="proveedor_id" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
<!-- Imagen -->
<div>
    <label class="block text-gray-700">Imagen</label>
    <input 
        type="file" 
        name="imagen" 
        id="imagen" 
        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
        accept="image/*"
    >
    <!-- Previsualización -->
    <div class="mt-2">
        <img id="preview" src="" alt="Vista previa" class="h-20 mt-1 rounded-md border hidden">
    </div>
</div>

<script>
    document.getElementById('imagen').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.classList.add('hidden');
        }
    });
</script>

            </div>

            <!-- Botón -->
            <button type="submit" class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Guardar Producto
            </button>
        </form>
    </div>

    <!-- Script para mostrar/ocultar fecha de vencimiento -->
    <script>
        document.getElementById('chk_vencimiento').addEventListener('change', function () {
            const divVencimiento = document.getElementById('div_vencimiento');
            divVencimiento.classList.toggle('hidden', !this.checked);
        });
    </script>
</x-app-layout>
