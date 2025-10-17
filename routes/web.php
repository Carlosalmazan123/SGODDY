<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\NotificacionController;
use App\Http\Middleware\RedirectIfClient;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TicketVirtualController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;
use App\Models\Categoria;
use App\Models\TicketVirtual;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
Route::get('/', function () {
    return view('welcome');
})->name("welcome");
Route::get('/inicio', function () {
    return view('inicio');
});
Route::get('/clinica', function () {
    return view('clinica');
});

Route::get('/google-auth/redirect', function () {

    return Socialite::driver('google')->redirect();

});
Route::get('/google-auth/callback', function () {
  
    $user_google = Socialite::driver('google')->stateless()->user();
    $user=User::updateOrCreate([
        'google_id' => $user_google->id,
    ],[
        'name'=>$user_google->name,
        
        'email'=>$user_google->email,
    ]);
    if (!$user->hasRole('cliente')) {
        $user->assignRole('cliente');
    }
    Auth::login($user);
    return redirect()->route('welcome');

});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', \App\Http\Middleware\RedirectIfClient::class])
    ->name('dashboard');

Route::get('/virtual', [TicketVirtualController::class, 'getReservas']);
Route::get('/horario', [TicketVirtualController::class, 'getHorarios']);
Route::get('/citas-ocupadas', [TicketVirtualController::class, 'obtenerCitasOcupadas']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/pacientes/{paciente}/historial/{historial}/reporte', [HistorialClinicoController::class, 'generarReporte'])
    ->name('historial.reporte')
    ->middleware('auth');
    Route::get('pacientes/{paciente}/historiales', [HistorialClinicoController::class, 'index'])
    ->name('historial.index');
    
Route::get('/pacientes/reporte/pdf', [PacienteController::class, 'reportePDF'])->name('pacientes.reporte.pdf');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tikets', [TicketVirtualController::class, 'inicio'])->name('tickets.inicio');
     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Ruta PUT para actualizar
     Route::get('/historial/create', [HistorialClinicoController::class, 'create']);
     Route::get('/historial/create/{pacienteId}', [HistorialClinicoController::class, 'create'])->name('historial.create');
     Route::post('/tickets/{id}/ocultar', [TicketVirtualController::class, 'ocultar'])->name('tickets.ocultar');
    Route::post('/citas/{id}/ocultar', [CitaController::class, 'ocultar'])->name('citas.ocultar');
    Route::post('/citas/{id}/restaurar', [CitaController::class, 'restaurar'])->name('citas.restaurar');
     Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generarPDF'])->name('facturas.pdf');
     Route::post('/historial/store/{pacienteId}', [HistorialClinicoController::class, 'store'])->name('historial.store');
     Route::get('/pacientes/{paciente}/historial/{historial}/edit', [HistorialClinicoController::class, 'edit'])->name('historial.edit');
     Route::put('/pacientes/{paciente}/historial/{historial}', [HistorialClinicoController::class, 'update'])->name('historial.update');
     Route::get('/facturas/create/{id}', [FacturaController::class, 'create'])->name('facturas.create');
Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
Route::get('/users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
     Route::get('/citas/{cita}/contrato', [CitaController::class, 'generarContrato'])
    ->name('citas.contrato');
    Route::delete('/users/force-delete-all', [UserController::class, 'forceDeleteAll'])
    ->name('users.forceDeleteAll');
    Route::delete('/citas/{id}/force-delete', [CitaController::class, 'forceDelete'])->name('citas.forceDelete');
Route::delete('/citas/force-delete-all', [CitaController::class, 'forceDeleteAll'])->name('citas.forceDeleteAll');
Route::get('/citas/deleted', [CitaController::class, 'deleted'])->name('citas.deleted');
Route::post('/citas/{id}/restore', [CitaController::class, 'restore'])->name('citas.restore');
Route::delete('/facturas/{id}/force-delete', [FacturaController::class, 'forceDelete'])->name('facturas.forceDelete');
Route::delete('/facturas/force-delete-all', [FacturaController::class, 'forceDeleteAll'])->name('facturas.forceDeleteAll');
Route::get('/facturas/deleted', [FacturaController::class, 'deleted'])->name('facturas.deleted');
Route::post('/facturas/{id}/restore', [FacturaController::class, 'restore'])->name('facturas.restore');   
Route::delete('/categorias/{id}/force-delete', [CategoriaController::class, 'forceDelete'])->name('categorias.forceDelete');
Route::delete('/categorias/force-delete-all', [CategoriaController::class, 'forceDeleteAll'])->name('categorias.forceDeleteAll');
Route::get('/categorias/deleted',   [CategoriaController::class, 'deleted'])->name('categorias.deleted');
Route::post('/categorias/{id}/restore', [CategoriaController::class, 'restore'])->name('categorias.restore');
Route::get('/proveedores/deleted', [ProveedorController::class, 'deleted'])->name('proveedores.deleted');
Route::post('/proveedores/{id}/restore', [ProveedorController::class, 'restore'])->name('proveedores.restore');
Route::delete('/proveedores/{id}/force-delete', [ProveedorController::class, 'forceDelete'])->name('proveedores.forceDelete');
Route::delete('/proveedores/force-delete-all', [ProveedorController::class, 'forceDeleteAll'])->name('proveedores.forceDeleteAll');
Route::get('/productos/deleted', [ProductoController::class, 'deleted'])->name('productos.deleted');
Route::post('/productos/{id}/restore', [ProductoController::class, 'restore'])->name('productos.restore');
Route::delete('/productos/{id}/force-delete', [ProductoController::class, 'forceDelete'])->name('productos.forceDelete');
Route::delete('/productos/force-delete-all', [ProductoController::class, 'forceDeleteAll'])->name('productos.forceDeleteAll');
Route::get('/propietarios/deleted', [PropietarioController::class, 'deleted'])->name('propietarios.deleted');
Route::post('/propietarios/{id}/restore', [PropietarioController::class, 'restore'])->name('propietarios.restore');
Route::delete('/propietarios/{id}/force-delete', [PropietarioController::class, 'forceDelete'])->name('propietarios.forceDelete');
Route::delete('/propietarios/force-delete-all', [PropietarioController::class, 'forceDeleteAll'])->name('propietarios.forceDeleteAll');
Route::get('/pacientes/deleted', [PacienteController::class, 'deleted'])->name('pacientes.deleted');
Route::post('/pacientes/{id}/restore', [PacienteController::class, 'restore'])->name('pacientes.restore');
Route::delete('/pacientes/{id}/force-delete', [PacienteController::class, 'forceDelete'])->name('pacientes.forceDelete');
Route::delete('/pacientes/force-delete-all', [PacienteController::class, 'forceDeleteAll'])->name('pacientes.forceDeleteAll'); 
Route::get('/historial/deleted', [HistorialClinicoController::class, 'deleted'])->name('historial.deleted');
Route::post('/historial/{id}/restore', [HistorialClinicoController::class, 'restore'])->name('historial.restore');
Route::delete('/historial/{id}/force-delete', [HistorialClinicoController::class, 'forceDelete'])->name('historial.forceDelete');
Route::delete('/historial/force-delete-all', [HistorialClinicoController::class, 'forceDeleteAll'])->name('historial.forceDeleteAll'); 
Route::get('/servicios/deleted', [ServicioController::class, 'deleted'])->name('servicios.deleted');
Route::post('/servicios/{id}/restore', [ServicioController::class, 'restore'])->name('servicios.restore');
Route::delete('/servicios/{id}/force-delete', [ServicioController::class, 'forceDelete'])->name('servicios.forceDelete');
Route::delete('/servicios/force-delete-all', [ServicioController::class, 'forceDeleteAll'])->name('servicios.forceDeleteAll');
Route::get('/inventario/deleted', [InventarioController::class, 'deleted'])->name('inventario.deleted');
Route::post('/inventario/{id}/restore', [InventarioController::class, 'restore'])->name('inventario.restore');
Route::delete('/inventario/{id}/force-delete', [InventarioController::class, 'forceDelete'])->name('inventario.forceDelete');
Route::delete('/inventario/force-delete-all', [InventarioController::class, 'forceDeleteAll'])->name('inventario.forceDeleteAll');
Route::get('/historial/{historial}', [HistorialClinicoController::class, 'show'])->name('historial.show');
Route::delete('/pacientes/{paciente}/historiales/{historial}', [HistorialClinicoController::class, 'destroy'])
    ->name('historial.destroy');


Route::get('/eliminado', function () {
    return view('eliminado');
})->name('eliminado.index');

    Route::get('/pacientes/{paciente}/factura/{factura}/show', [FacturaController::class, 'show'])->name('factura.show');
    Route::get('/pacientes/{paciente}/factura/{factura}/edit', [FacturaController::class, 'edit'])->name('factura.edit');
    Route::resource('facturas', FacturaController::class);
    Route::resource("users", "App\Http\Controllers\UserController");
    Route::resource("roles", "App\Http\Controllers\RoleController" );
    
    Route::resource('propietarios', PropietarioController::class);
Route::resource('pacientes', PacienteController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('productos', ProductoController::class);
Route::resource('citas', CitaController::class);
Route::resource('inventario', InventarioController::class);

Route::resource('servicios', ServicioController::class);
Route::get('/servicios/{id}/duracion', [ServicioController::class, 'obtenerDuracion']);
//Route::resource('historial', HistorialClinicoController::class);

Route::get('/generar-ticket', [TicketVirtualController::class, 'generar'])->name('tickets.generar');
Route::post('/tickets/{ticket}/atender', [TicketVirtualController::class, 'actualizarEstado'])->name('tickets.atender');
Route::post('/citas/{cita}/atender', [CitaController::class, 'actualizarEstado'])->name('citas.atender');
Route::patch('/notificaciones/{id}/leer', function ($id) {
    $user = Auth::user(); // Obtiene el usuario autenticado

    if ($user) {
        $notificacion = $user->notifications()->find($id); // Busca la notificación por ID

        if ($notificacion) {
            $notificacion->markAsRead(); // Marca la notificación como leída
        }
    }
    return back();
})->name('notificaciones.marcarLeida');
Route::get('/obtener-eventos', [CitaController::class, 'obtenerEventos']); // Para el calendario
Route::patch('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcarLeida');
Route::patch('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.leerTodas');
Route::post('/push-subscribe', function (Request $request) {
    $request->user()->updatePushSubscription(
        $request->input('endpoint'),
        $request->input('keys.p256dh'),
        $request->input('keys.auth')
    );
});
Route::post('/reservar-cita', [TicketVirtualController::class, 'reservarCita'])
    ->name('reservar.cita');
    Route::get('/citas/{id}/pdf', [CitaController::class, 'generarPDF'])->name('citas.pdf');
    Route::get('/inventario/reporte/pdf', [InventarioController::class, 'reportePDF'])->name('inventario.reporte.pdf');
    Route::get('/ventas/reporte/pdf', [FacturaController::class, 'reportePDF'])
         ->name('ventas.reporte.pdf');

}); 

Route::resource('tickets', TicketVirtualController::class);
Route::get('/tickets', [TicketVirtualController::class, 'index'])->name('tickets.index');
Route::get('/buscar-global', [App\Http\Controllers\BusquedaGlobalController::class, 'buscar'])->name('buscar.global');
Auth::routes(["register"=>false, "reset"=>false]);
require __DIR__.'/auth.php';
Route::get("user/{user}/roles", "App\Http\Controllers\UserRoleController@edit")->name("users.roles.edit");
Route::put("user/{user}/roles", "App\Http\Controllers\UserRoleController@update")->name("users.roles.update");

Route::get("/roles/{role}/permissions", "App\Http\Controllers\RolePermissionController@edit")->name("roles.permissions.edit");
Route::put("/roles/{role}/permissions", "App\Http\Controllers\RolePermissionController@update")->name("roles.permissions.update");
Route::post('/whatsapp/recordatorio', [App\Http\Controllers\WhatsAppController::class, 'enviarRecordatorio'])->name('whatsapp.recordatorio');


Route::get("/offline", function () {
    return view('offline');
});

