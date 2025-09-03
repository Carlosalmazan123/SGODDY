<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Resultados para "{{ $query }}"</h2>

            @foreach ($paginador as $bloque)
            <div class="mb-6">
                @if ($bloque['nombre'] === 'Pacientes')
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Pacientes</h3>
                    <table class="w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-blue-100 font-semibold">
                            <tr>
                                <th class="p-4">Nombre</th>
                                <th class="p-4">Especie</th>
                                <th class="p-2">Raza</th>
                                <th class="p-4">Propietario</th>
                                <th class="p-2">Edad</th>
                                <th class="p-2">Sexo</th>
                                <th class="p-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bloque['resultados'] as $paciente)
                                <tr class="border-b">
                                    <td class="p-4">{{ $paciente->nombre }}</td>
                                    <td class="p-4">{{ $paciente->especie }}</td>
                                    <td class="p-2">{{ $paciente->raza ? $paciente->raza : 'Sin especificar' }}</td>
                                    <td class="p-4">{{ $paciente->relPropietario->nombre }} {{ $paciente->relPropietario->apellido }}</td>
                                    <td class="p-2">{{ $paciente->edad }}</td>
                                    <td class="p-2">{{ $paciente->sexo }}</td>
                                    <td class="p-4 text-center space-x-2">
                                        @can("paciente.edit")
                                        <a href="{{ route('pacientes.edit', $paciente) }}" class="text-blue-600 hover:underline">
                                            <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                        </a>
                                        @endcan
                                        @can("paciente.delete")
                                        <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($bloque['nombre'] === 'Usuarios')
                    <h3 class="text-lg font-semibold text-green-700 mb-2">Usuarios</h3>
                    <table class="w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-green-100 font-semibold">
                            <tr>
                                <th class="p-2">Nombre</th>
                                <th class="p-2">Correo</th>
                                <th class="p-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bloque['resultados'] as $usuario)
                                <tr class="border-b">
                                    <td class="p-2">{{ $usuario->name }}</td>
                                    <td class="p-2">{{ $usuario->email }}</td>
                                    <td class="p-2 text-center flex justify-center items-center space-x-2">
                                        @can("user.edit")
                                        <a href="{{ route('users.edit', $usuario) }}" class="text-blue-600 hover:text-blue-800">
                                            <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                        </a>
                                        @endcan
                                        @can("user.delete")
                                        <form action="{{ route('users.destroy', $usuario) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este usuario?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($bloque['nombre'] === 'Propietarios')
                    <h3 class="text-lg font-semibold text-purple-700 mb-2">Propietarios</h3>
                    <table class="w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-purple-100 font-semibold">
                            <tr>
                                <th class="p-2">Nombre</th>
                                <th class="p-2">Apellido</th>
                                <th class="p-2">Teléfono</th>
                                <th class="p-2">Dirección</th>
                                <th class="p-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bloque['resultados'] as $propietario)
                                <tr class="border-b">
                                    <td class="p-2">{{ $propietario->nombre }}</td>
                                    <td class="p-2">{{ $propietario->apellido }}</td>
                                    <td class="p-2">{{ $propietario->telefono }}</td>
                                    <td class="p-2">{{ $propietario->direccion }}</td>
                                    <td class="p-2 text-center space-x-2">
                                        @can("proopietario.edit")
                                        <a href="{{ route('propietarios.edit', $propietario) }}" class="text-blue-600 hover:underline">
                                            <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                        </a>
                                        @endcan
                                        @can("propietario.delete")
                                        <form action="{{ route('propietarios.destroy', $propietario) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este propietario?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($bloque['nombre'] === 'Productos')
                    <h3 class="text-lg font-semibold text-pink-700 mb-2">Productos</h3>
                    <table class="w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-pink-100 font-semibold">
                            <tr>
                                <th class="p-2">Nombre</th>
                                <th class="p-2">Precio</th>
                                <th class="p-2">Stock</th>
                                <th class="p-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bloque['resultados'] as $producto)
                                <tr class="border-b">
                                    <td class="p-2">{{ $producto->nombre }}</td>
                                    <td class="p-2">Bs {{ number_format($producto->precio, 2) }}</td>
                                    <td class="p-2">{{ $producto->stock }}</td>
                                    <td class="p-2 text-center space-x-2">
                                        @can("producto.edit")
                                        <a href="{{ route('productos.edit', $producto) }}" class="text-blue-600 hover:underline">
                                            <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                        </a>
                                        @endcan
                                        @can("producto.delete")
                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este producto?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:underline">
                                                <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if($bloque['nombre'] === 'Servicios')
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-yellow-700 mb-2">Servicios</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-yellow-100 font-semibold">
                    <tr>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Descripción</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Duración</th>
                        <th class="p-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloque['resultados'] as $servicio)
                        <tr class="border-b">
                            <td class="p-2">{{ $servicio->nombre }}</td>
                            <td class="p-2">{{ $servicio->descripcion }}</td>
                            <td class="p-2">Bs {{ number_format($servicio->precio, 2) }}</td>
                            <td class="p-2">{{ $servicio->duracion }} min</td>
                            <td class="p-2 text-center space-x-2">
                                @can("servicio.edit")
                                <a href="{{ route('servicios.edit', $servicio) }}" class="text-blue-600 hover:underline"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                @endcan
                                @can("servicio.delete")
                                <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este servicio?')">
                                    @csrf @method('DELETE')
                                    <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($bloque['nombre'] === 'Citas')
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-red-700 mb-2">Citas</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-red-100 font-semibold">
                    <tr>
                        <th class="p-4">Paciente</th>
                        <th class="p-4">Propietario</th>
                        <th class="p-4">Servicio</th>
                        <th class="p-4">Fecha</th>
                        <th class="p-4">Hora</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloque['resultados'] as $cita)
                        <tr class="border-b">
                            <td class="p-4">{{ $cita->relPaciente->nombre }}</td>
                            <td class="p-4">{{ $cita->propietario->nombre }}</td>
                            <td class="p-4">{{ $cita->servicio->nombre }}</td>
                            <td class="p-4">{{ $cita->fecha_cita }}</td>
                            <td class="p-4">{{ $cita->hora_cita }}</td>
                            <td class="p-4">{{ $cita->estado }}</td>
                            <td class="p-4 text-center space-x-2">
                                @can("cita.edit")
                                <a href="{{ route('citas.edit', $cita) }}" class="text-blue-600 hover:underline"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                @endcan
                                @can("cita.delete")
                                <form action="{{ route('citas.destroy', $cita) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta cita?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline"><ion-icon name="trash-outline" class="h-6 w-6"></ion-icon></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($bloque['nombre'] === 'Inventarios')
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Inventarios</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-4">Producto</th>
                        <th class="p-4">Cantidad</th>
                        <th class="p-4">Tipo Movimiento</th>
                        <th class="p-4">Descripción</th>
                        <th class="p-4">Fecha</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloque['resultados'] as $inventario)
                        <tr class="border-b">
                            <td class="p-4">{{ $inventario->producto->nombre }}</td>
                            <td class="p-4">{{ $inventario->cantidad }}</td>
                            <td class="p-4 capitalize">{{ $inventario->tipo_movimiento }}</td>
                            <td class="p-4">{{ $inventario->descripcion }}</td>
                            <td class="p-4">{{ $inventario->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-center space-x-2">
                                @can("inventario.edit")
                                <a href="{{ route('inventario.edit', $inventario) }}" class="text-blue-600 hover:underline"><ion-icon name="create-outline" class="h-6 w-6"></ion-icon></a>
                                @endcan
                                @can("inventario.delete")
                                <form action="{{ route('inventario.destroy', $inventario) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este movimiento?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline"><ion-icon name="trash-outline" class="h-6 w-6"></ion-icon></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif($bloque['nombre'] === 'Tickets Virtuales')
        <div class="mb-6" x-data="{ modalOpen: false, ticketActual: null }">
            @foreach(
                $bloque['resultados']
                    ->where('visible', 1)
                    ->reject(fn($t) => $t->user->hasRole('admin') || $t->user->hasRole('veterinario'))
                as $ticket
            )
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tickets</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-4">Cliente</th>
                        <th class="p-4">Nombre de la mascota</th>
                        <th class="p-4">Especie</th>
                        <th class="p-4">Tipo del servicio</th>
                        <th class="p-4">Fecha</th>
                        <th class="p-4">Hora</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                   

                        <tr class="border-b">
                            <td class="p-4">{{ $ticket->user->name }}</td>
                            <td class="p-4">{{ $ticket->nombre_mascota }}</td>
                            <td class="p-4">{{ $ticket->tipo_mascota }}</td>
                            <td class="p-4">{{ $ticket->servicio->nombre }}</td>
                            <td class="p-4">{{ $ticket->fecha_cita }}</td>
                            <td class="p-4">{{ $ticket->hora_cita }}</td>
                            <td class="p-4 text-center space-x-2">
                                <button 
                                    @click='modalOpen = true; ticketActual = @json($ticket)'
                                    class="text-blue-500 hover:underline"
                                >
                                    <ion-icon name="eye-outline" class="h-6 w-6"></ion-icon>
                                </button>
    
                                <!-- Ocultar fila visualmente -->
                            <button
                            class="text-green-500 hover:text-green-800" title="Atendido"
                            @click.prevent="fetch('/tickets/{{ $ticket->id }}/ocultar', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(() => location.reload())">
                            <ion-icon name="checkmark-done-outline" class="h-6 w-6"></ion-icon>
                        </button>
                            </td>
                        </tr>
                    
                </tbody>
            </table>
            @endforeach
            <!-- Modal -->
            <div x-show="modalOpen" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
                    <h2 class="text-xl font-bold mb-4">Detalles del Ticket</h2>
    
                    <!-- Botón X para cerrar -->
                    <button @click="modalOpen = false"
                        class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
    
                    <template x-if="ticketActual">
                        <div class="space-y-2 text-left">
                            <p><strong>Cliente:</strong> <span x-text="ticketActual.user.name"></span></p>
                            <p><strong>Mascota:</strong> <span x-text="ticketActual.nombre_mascota"></span></p>
                            <p><strong>Especie:</strong> <span x-text="ticketActual.tipo_mascota"></span></p>
                            <p><strong>Servicio:</strong> <span x-text="ticketActual.servicio.nombre"></span></p>
                            <p><strong>Fecha:</strong> <span x-text="ticketActual.fecha_cita"></span></p>
                            <p><strong>Hora:</strong> <span x-text="ticketActual.hora_cita"></span></p>
                            <p><strong>Estado:</strong> <span x-text="ticketActual.estado"></span></p>
                            <p><strong>Observación:</strong> <span x-text="ticketActual.observacion ?? 'N/A'"></span></p>
                        </div>
                    </template>
    
                    <!-- Botón inferior para cerrar -->
                    <div class="mt-6 text-right">
                        <button @click="modalOpen = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    
    @elseif ($bloque['nombre'] === 'Proveedores')
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Proveedores</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-4">Nombre</th>
                        <th class="p-4">Teléfono</th>
                        <th class="p-4">Dirección</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloque['resultados'] as $proveedor)
                        <tr class="border-b">
                            <td class="p-4">{{ $proveedor->nombre }}</td>
                            <td class="p-4">{{ $proveedor->telefono }}</td>
                            <td class="p-4">{{ $proveedor->direccion }}</td>
                            <td class="p-4 text-center space-x-2">
                                @can("proveedor.edit")
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-blue-600 hover:underline">

                                    <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                </a>
                                @endcan
                                @can("proveedor.delete")
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este proveedor?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif ($bloque['nombre'] === 'Facturas')
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Ventas</h3>
            <table class="w-full text-sm text-left text-gray-700 border">
                <thead class="bg-gray-100 font-semibold">
                    <tr>
                        <th class="p-4">Paciente</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Método de pago</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloque['resultados'] as $factura)

                        <tr class="border-b">
                            <td class="p-4">{{ $factura->paciente->nombre }}</td>
                            <td class="p-4">Bs {{ number_format($factura->total, 2) }}</td>
                            <td class="p-4">{{ $factura->metodo_pago }}</td>
                            <td class="p-4">{{ $factura->estado }}</td>
                            <td class="p-4 text-center space-x-2">
                                @can("factura.edit")
                                <a href="{{ route('facturas.edit', $factura) }}" class="text-blue-600 hover:underline">
                                    <ion-icon name="create-outline" class="h-6 w-6"></ion-icon>
                                </a>
                                @endcan
                                @can("factura.delete")
                                <form action="{{ route('facturas.destroy', $factura) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta factura?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        <ion-icon name="trash-outline" class="h-6 w-6"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
            </div>
        @endforeach
        
        <!-- Paginación -->
        <div class="mt-4">
            {{ $paginador->appends(['busqueda' => $query])->links() }}
        </div>
        </div>
       
    </div>
</x-app-layout>
