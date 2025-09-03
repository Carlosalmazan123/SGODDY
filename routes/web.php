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
Route::get('/pacientes/reporte/pdf', [PacienteController::class, 'reportePDF'])->name('pacientes.reporte.pdf');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tikets', [TicketVirtualController::class, 'inicio'])->name('tickets.inicio');
     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Ruta PUT para actualizar
     Route::get('/historial/create', [HistorialClinicoController::class, 'create']);
     Route::get('/historial/create/{pacienteId}', [HistorialClinicoController::class, 'create'])->name('historial.create');
     Route::post('/tickets/{id}/ocultar', [TicketVirtualController::class, 'ocultar'])->name('tickets.ocultar');
    Route::post('/citas/{id}/ocultar', [CitaController::class, 'ocultar'])->name('citas.ocultar');
     Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generarPDF'])->name('facturas.pdf');
     Route::post('/historial/store/{pacienteId}', [HistorialClinicoController::class, 'store'])->name('historial.store');
     Route::get('/pacientes/{paciente}/historial/{historial}/edit', [HistorialClinicoController::class, 'edit'])->name('historial.edit');
     Route::put('/pacientes/{paciente}/historial/{historial}', [HistorialClinicoController::class, 'update'])->name('historial.update');

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

