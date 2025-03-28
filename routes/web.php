<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CitaController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', \App\Http\Middleware\RedirectIfClient::class])->name('dashboard');


Route::get('/virtual', [TicketVirtualController::class, 'getReservas']);
Route::get('/horario', [TicketVirtualController::class, 'getHorarios']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tikets', [TicketVirtualController::class, 'inicio'])->name('tickets.inicio');
     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Ruta PUT para actualizar
     Route::get('/historial/create', [HistorialClinicoController::class, 'create']);
     Route::get('/historial/create/{pacienteId}', [HistorialClinicoController::class, 'create'])->name('historial.create');

     Route::post('/historial/store/{pacienteId}', [HistorialClinicoController::class, 'store'])->name('historial.store');
     Route::get('/pacientes/{paciente}/historial/{historial}/edit', [HistorialClinicoController::class, 'edit'])->name('historial.edit');
     Route::put('/pacientes/{paciente}/historial/{historial}', [HistorialClinicoController::class, 'update'])->name('historial.update');
    Route::resource("users", "App\Http\Controllers\UserController");
    Route::resource("roles", "App\Http\Controllers\RoleController" );
    Route::resource('propietarios', PropietarioController::class);
Route::resource('pacientes', PacienteController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('productos', ProductoController::class);
Route::resource('citas', CitaController::class);
Route::resource('inventario', InventarioController::class);
Route::resource('facturas', FacturaController::class);
Route::resource('servicios', ServicioController::class);
//Route::resource('historial', HistorialClinicoController::class);

Route::get('/generar-ticket', [TicketVirtualController::class, 'generar'])->name('tickets.generar');
Route::post('/tickets/{ticket}/atender', [TicketVirtualController::class, 'actualizarEstado'])->name('tickets.atender');
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
});
Route::resource('tickets', TicketVirtualController::class);
Route::get('/tickets', [TicketVirtualController::class, 'index'])->name('tickets.index');
Auth::routes(["register"=>false, "reset"=>false]);
require __DIR__.'/auth.php';
Route::get("user/{user}/roles", "App\Http\Controllers\UserRoleController@edit")->name("users.roles.edit");
Route::put("user/{user}/roles", "App\Http\Controllers\UserRoleController@update")->name("users.roles.update");

Route::get("/roles/{role}/permissions", "App\Http\Controllers\RolePermissionController@edit")->name("roles.permissions.edit");
Route::put("/roles/{role}/permissions", "App\Http\Controllers\RolePermissionController@update")->name("roles.permissions.update");

