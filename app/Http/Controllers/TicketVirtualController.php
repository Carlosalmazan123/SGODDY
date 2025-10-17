<?php
namespace App\Http\Controllers;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\TicketVirtual;
use App\Models\User;
use App\Notifications\ReservaCreada;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
class TicketVirtualController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\VerificarCliente::class)->only(['store', 'index']);
    }
   public function index()
{
    $servicios = \App\Models\Servicio::all();
    $isAuthenticated = Auth::check(); // Retorna true si está autenticado
    $emailSesion = $isAuthenticated ? Auth::user()->email : '';
    $userName = $isAuthenticated ? Auth::user()->name : '';
    $user = $isAuthenticated ? Auth::user() : null;

    // Buscar propietario si el usuario está autenticado
    $propietario = null;
    if ($isAuthenticated && $emailSesion) {
        $propietario = \App\Models\Propietario::where('correo', $emailSesion)->with('pacientes')->first();
    }

    return view('ticket_index', compact('isAuthenticated', 'emailSesion', 'user', 'userName', 'servicios', 'propietario')); 
}

    public function inicio()
{
    $tickets = TicketVirtual::where('visible', true)
    ->whereHas('user.roles', function ($query) {
        $query->where('name', 'cliente');
    })
    ->with(['user', 'servicio'])
    ->orderBy('fecha_cita', 'asc')
    ->orderBy('hora_cita', 'asc')
    ->paginate(6); 

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
        'nombre_mascota' => 'nullable|string|max:255',
        'tipo_mascota' => 'nullable|string|max:255', // Opcional si se usa paciente_id
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
    $servicio = Servicio::findOrFail($validatedData['servicio_id']); 
    // Crear ticket virtual con datos de la cita (si existe) o directamente del formulario
    $ticket = TicketVirtual::create([
        'nombre_mascota' => $nombreMascota,
        'tipo_mascota' => $validatedData['tipo_mascota'],
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
    public function obtenerCitasOcupadas(Request $request)
    {
        $fecha = $request->fecha;
    
        $citas = TicketVirtual::where('fecha_cita', $fecha)
            ->join('servicios', 'tickets_virtuales.servicio_id', '=', 'servicios.id')
            ->get(['hora_cita', 'servicios.duracion']); // duración en HH:MM
    
        return response()->json($citas);
    }
    public function show(TicketVirtual $ticket)
    {
        return view('ticket_show', compact('ticket'));
    }
 public function reservarCita(Request $request)
{
    try {
        if (!Auth::check()) {
            return response()->json(['error' => '⚠️ Usuario no autenticado.'], 401);
        }

        $usuarioId = $request->input('user_id') ?? auth()->id();

        $request->validate([
            'fecha_cita'   => 'required|date|after_or_equal:today',
            'hora_cita'    => 'required|string',
            'servicio_id'  => 'required|exists:servicios,id',

            // Validamos solo si paciente_id no se envía
            'nombre_mascota' => 'required_without:paciente_id|string',
            'tipo_mascota'   => 'required_without:paciente_id|string',
            'paciente_id'    => 'nullable|exists:pacientes,id',
        ]);

        $fecha      = $request->input('fecha_cita');
        $hora       = $request->input('hora_cita');
        $servicioId = $request->input('servicio_id');
        $pacienteId = $request->input('paciente_id');

        // ✅ Validación de fecha y hora contra el servidor
        $fechaHoraSeleccionada = \Carbon\Carbon::parse("$fecha $hora");
        if ($fechaHoraSeleccionada->isPast()) {
            return response()->json(['error' => '⛔ No se pueden reservar horarios pasados.'], 422);
        }

        // Ver si se seleccionó un paciente registrado
        if ($pacienteId) {
            $paciente = \App\Models\Paciente::find($pacienteId);
            $nombreMascota = $paciente->nombre;
            $tipoMascota   = $paciente->especie;
        } else {
            $mascotaInput     = $request->input('nombre_mascota');
            $tipoMascotaInput = $request->input('tipo_mascota');

            // Si el input es un número, asumimos que es un ID de paciente
            if (is_numeric($mascotaInput)) {
                $paciente = \App\Models\Paciente::find($mascotaInput);

                if ($paciente) {
                    $nombreMascota = $paciente->nombre;
                    $tipoMascota   = $paciente->especie;
                } else {
                    return response()->json(['error' => '⚠️ Mascota no encontrada.'], 404);
                }
            } else {
                // En caso de que el usuario haya escrito directamente el nombre
                $nombreMascota = $mascotaInput;
                $tipoMascota   = $tipoMascotaInput;
            }
        }

        return DB::transaction(function () use (
            $fecha, $hora, $servicioId, $usuarioId,
            $nombreMascota, $tipoMascota,
        ) {
            $citaExistente = DB::table('tickets_virtuales')
                ->where('fecha_cita', $fecha)
                ->where('hora_cita', $hora)
                ->lockForUpdate()
                ->first();

            if ($citaExistente) {
                return response()->json(['error' => '⛔ Esta hora ya está ocupada.'], 409);
            }

            $servicio = \App\Models\Servicio::find($servicioId);

            $ticketId = DB::table('tickets_virtuales')->insertGetId([
                'user_id'       => $usuarioId,
                'servicio_id'   => $servicioId,
                'nombre_mascota'=> $nombreMascota,
                'tipo_mascota'  => $tipoMascota,
                'fecha_cita'    => $fecha,
                'hora_cita'     => $hora,
                'title'         => "{$hora} - {$servicio->nombre}",
                'start'         => $fecha . ' ' . $hora,
                'end'           => $fecha . ' ' . $hora,
                'color'         => "#3F99F5",
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            $ticket = \App\Models\TicketVirtual::with('servicio')->find($ticketId);

            // Notificar administradores
            $admins = \App\Models\User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->get();

            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\ReservaCreada($ticket));
            }

            

            return response()->json([
                'message'        => '✅ Cita reservada con éxito',
                'ticket_id'      => $ticket->id,
                'fecha_cita'     => $ticket->fecha_cita,
                'hora_cita'      => $ticket->hora_cita,
                'servicio'       => $ticket->servicio->nombre,
                'nombre_mascota' => $ticket->nombre_mascota,
                'tipo_mascota'   => $ticket->tipo_mascota,
                'precio_servicio'=> $ticket->servicio->precio,
            ]);
        });

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => '⚠️ Errores de validación: ' . implode(', ', $e->errors())], 400);
    } catch (\Exception $e) {
        \Log::error("Error al reservar cita: " . $e->getMessage());
        return response()->json(['error' => '⚠️ Error interno en el servidor.'], 500);
    }
}


    public function ocultar($id)
{
    $ticket = TicketVirtual::findOrFail($id);
    $ticket->visible = false;
    $ticket->save();

    return response()->json(['success' => true]);
}

public function destroy(TicketVirtual $ticket)
{
    try {
        $ticket->delete();
        return redirect()->route('tickets.inicio')->with('success', 'Ticket eliminado correctamente.');
    } catch (QueryException $e) {
        return redirect()->route('tickets.inicio')->with('error', '⚠️ No se puede eliminar el ticket porque está en uso.');
    }
}
}
