<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\TicketVirtual;
use App\Models\User;
use App\Notifications\ReservaCreada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
class TicketVirtualController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\VerificarCliente::class)->only(['store', 'index', 'inicio']);
    }
    
    public function index()
    {    $user=User::get();
        $servicios = \App\Models\Servicio::all();
        $isAuthenticated = Auth::check(); // Retorna true si está autenticado
        $emailSesion = $isAuthenticated ? Auth::user()->email : '';
        $userName = $isAuthenticated ? Auth::user()->name : '';
        return view('ticket_index', compact('isAuthenticated', 'emailSesion','user','userName','servicios'));
    }
    public function inicio()
{
    // Obtener solo los tickets cuyos usuarios tienen el rol de "cliente"
    $tickets = TicketVirtual::whereHas('user.roles', function ($query) {
        $query->where('name', 'cliente');
    })->with('user')->orderBy('fecha_cita', 'desc')->get();
    
    return view('ticket_inicio', compact('tickets'));
}

  
    
    public function getReservas()
    {
        $reservas = TicketVirtual::all(['title', 'start', 'end', 'color']); // Asegúrate de que la tabla tenga estos campos

        return response()->json($reservas);
    }
    

    public function getHorarios(Request $request)
{
    $fecha = $request->query('fecha'); // Obtener fecha desde la URL
    $datos = DB::table('tickets_virtuales')->where('fecha_cita', $fecha)->get();

    $ocupadas = []; // Array para las horas ocupadas

    if ($datos->isNotEmpty()) {
        // Extraer las horas ocupadas
        $ocupadas = $datos->pluck('hora_cita')->toArray();
    }

    // Regresar las horas ocupadas en formato JSON
    return response()->json([
        'ocupadas' => $ocupadas
    ]);
}

public function store(Request $request)
{
    // Validación de datos para ambas tablas
    $validatedData = $request->validate([
        'paciente_id' => 'nullable|exists:pacientes,id', // Paciente opcional si se usa citas
        'propietario_id' => 'nullable|exists:propietarios,id',
        'nombre_mascota' => 'nullable|string|max:255', // Opcional si se usa paciente_id
        'servicio_id' => 'required|exists:servicios,id',
        'fecha_cita' => 'required|date|after_or_equal:today',
        'hora_cita' => 'required|string|max:255',
        'estado' => 'nullable|in:Pendiente,Confirmada,Cancelada', // Solo para citas
    ]);

    $user = Auth::user();
    if (!$user) {
        return redirect()->back()->with('error', 'Debes iniciar sesión para hacer una reserva.');
    }

    // Si hay paciente_id, obtenemos el nombre del paciente; si no, usamos nombre_mascota
$nombreMascota = $validatedData['nombre_mascota'] ?? null;

if (!empty($validatedData['paciente_id'])) { // Verificar si existe antes de acceder
    $paciente = Paciente::find($validatedData['paciente_id']);
    $nombreMascota = $paciente ? $paciente->nombre : 'Paciente Desconocido';
}


    // Buscar el servicio
    $servicio = Servicio::findOrFail($validatedData['servicio_id']);

   
    // Crear ticket virtual con datos de la cita (si existe) o directamente del formulario
    $ticket = TicketVirtual::create([
        'nombre_mascota' => $nombreMascota,
        'servicio_id' => $validatedData['servicio_id'],
        'fecha_cita' => $validatedData['fecha_cita'],
        'hora_cita' => $validatedData['hora_cita'],
        'user_id' => $user->id,
        'title' => $servicio->nombre,
        'start' => $validatedData['fecha_cita'],
        'end' => $validatedData['fecha_cita'],
        'color' => '#3F99F5',
    ]);

    // Notificar a los administradores sobre la cita/ticket
    $admins = User::whereHas('roles', function ($query) {
        $query->where('name', 'admin');
    })->get();

    foreach ($admins as $admin) {
        $admin->notify(new ReservaCreada($ticket));
    }

    return redirect()->route('tickets.index')->with('success', 'Cita y Ticket Virtual creados correctamente.');
}



    public function actualizarEstado(TicketVirtual $ticket)
    {
        $ticket->update(['estado' => 'Atendido']);
        return redirect()->route('tickets.index')->with('success', 'Ticket marcado como atendido.');
    }
}
