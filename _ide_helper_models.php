<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Producto> $productos
 * @property-read int|null $productos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereUpdatedAt($value)
 */
	class Categoria extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $paciente_id
 * @property int $propietario_id
 * @property string $fecha_cita
 * @property string $hora_cita
 * @property int $servicio_id
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Paciente $relPaciente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereFechaCita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereHoraCita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita wherePacienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita wherePropietarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cita whereUpdatedAt($value)
 */
	class Cita extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $paciente_id
 * @property string $total
 * @property string $metodo_pago
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Paciente $paciente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura wherePacienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Factura whereUpdatedAt($value)
 */
	class Factura extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $anamnesis
 * @property string $diagnostico
 * @property string $examen
 * @property array<array-key, mixed> $fecha
 * @property array<array-key, mixed> $tratamiento
 * @property array<array-key, mixed> $observaciones
 * @property int $paciente_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Paciente $paciente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereAnamnesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereDiagnostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico wherePacienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistorialClinico whereUpdatedAt($value)
 */
	class HistorialClinico extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $producto_id
 * @property int $cantidad
 * @property string $tipo_movimiento
 * @property string|null $descripcion
 * @property string $fecha_movimiento
 * @property int|null $usuario_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Producto $producto
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereProductoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereTipoMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventario whereUsuarioId($value)
 */
	class Inventario extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string $especie
 * @property string|null $raza
 * @property int $edad
 * @property string $sexo
 * @property string $color
 * @property string $peso
 * @property int $propietario_id
 * @property string|null $imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HistorialClinico> $historial
 * @property-read int|null $historial_count
 * @property-read \App\Models\Cita|null $relCita
 * @property-read \App\Models\Propietario $relPropietario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereEdad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereEspecie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente wherePropietarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereRaza($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereUpdatedAt($value)
 */
	class Paciente extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $categoria_id
 * @property string $precio
 * @property int $stock
 * @property string $unidad_medida
 * @property string|null $fecha_vencimiento
 * @property int|null $proveedor_id
 * @property string|null $imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categoria $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inventario> $inventarios
 * @property-read int|null $inventarios_count
 * @property-read \App\Models\Proveedor|null $proveedor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereFechaVencimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereProveedorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereUnidadMedida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Producto whereUpdatedAt($value)
 */
	class Producto extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property string|null $direccion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Paciente> $relPaciente
 * @property-read int|null $rel_paciente_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereUpdatedAt($value)
 */
	class Propietario extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $contacto
 * @property string|null $telefono
 * @property string|null $email
 * @property string|null $direccion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Producto> $productos
 * @property-read int|null $productos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proveedor whereUpdatedAt($value)
 */
	class Proveedor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $precio
 * @property string $duracion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $activo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TicketVirtual> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereDuracion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Servicio whereUpdatedAt($value)
 */
	class Servicio extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre_mascota
 * @property string $tipo_mascota
 * @property string $fecha_cita
 * @property string $hora_cita
 * @property string $title
 * @property string $start
 * @property string $end
 * @property string $color
 * @property int|null $user_id
 * @property int $servicio_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Servicio $servicio
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereFechaCita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereHoraCita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereNombreMascota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereTipoMascota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TicketVirtual whereUserId($value)
 */
	class TicketVirtual extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $google_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

