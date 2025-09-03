<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Propietario;
use App\Models\Servicio;
use App\Models\TicketVirtual;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use CitaPendienteNotification;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function __construct(){
        $this->middleware("can:cita.index")->only("index");
        $this->middleware("can:cita.create")->only("create","store");
        $this->middleware("can:cita.edit")->only("edit","update");
        $this->middleware("can:cita.delete")->only("destroy");
    }
    public function index() {
        $citas = Cita::where('visible', true)->with(['relPaciente.relPropietario', 'servicio'])->paginate(6);

        $citasJson = collect($citas->items())->map(function ($cita) {
            return [
                'id' => $cita->id,
                'fecha_cita' => $cita->fecha_cita,
                'hora_cita' => $cita->hora_cita,
                'estado' => $cita->estado,
                'rel_paciente' => [
                    'nombre' => $cita->relPaciente->nombre,
                    'rel_propietario' => [
                        'nombre' => $cita->relPaciente->relPropietario->nombre,
                    ],
                ],
                'servicio' => [
                    'nombre' => $cita->servicio->nombre,
                ],
                
            ];
          
        });
      
        $pacientes = Paciente::all();
        return view('cita_index', [
            'citas' => $citas,
            'citasJson' => $citasJson,
            'pacientes' => $pacientes,
        ]);
                
    }
    

    public function create() {
        $pacientes=Paciente::all();
        $propietarios=Propietario::all();
        $servicios=Servicio::all();
        $citas=Cita::all();
        return view('cita_create', ['pacientes' => $pacientes,"citas"=>$citas,"propietarios"=>$propietarios,"servicios"=>$servicios   ]);
    }
 public function generarPDF($id)
    {
        // Buscar la cita
        $cita = Cita::with(['servicio', 'paciente.propietario'])->findOrFail($id);

        // Renderizar vista con los datos de la cita
        $pdf = Pdf::loadView('cita_show', compact('cita'));

        // Descargar el archivo o mostrarlo en navegador
        return $pdf->stream("cita_{$cita->id}.pdf");
    }
    public function store(Request $request)
{
    // Validación de los datos del formulario
    $validatedData = $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'propietario_id' => 'required|exists:propietarios,id',
        'fecha_cita' => 'required|date|after_or_equal:today',
        'hora_cita' => 'required|string|max:255',
        'servicio_id' => 'required|exists:servicios,id',
        'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
    ]);

    // Buscar datos relacionados
    $paciente = \App\Models\Paciente::find($validatedData['paciente_id']);
    $servicio = \App\Models\Servicio::find($validatedData['servicio_id']);
    $user = \Illuminate\Support\Facades\Auth::user(); // Opcional si deseas registrar al usuario actual

    // Guardar en la tabla citas
    $cita = \App\Models\Cita::create([
        'paciente_id' => $validatedData['paciente_id'],
        'propietario_id' => $validatedData['propietario_id'],
        'fecha_cita' => $validatedData['fecha_cita'],
        'hora_cita' => $validatedData['hora_cita'],
        'servicio_id' => $validatedData['servicio_id'],
        'estado' => $validatedData['estado'],
    ]);
    
    // Crear el ticket virtual con los mismos datos
    \App\Models\TicketVirtual::create([
        'nombre_mascota' => $paciente->nombre,
        'tipo_mascota' => $paciente->raza ?? 'N/D',
        'fecha_cita' => $validatedData['fecha_cita'],
        'hora_cita' => $validatedData['hora_cita'],
        'title' => "{$validatedData['hora_cita']} - {$servicio->nombre}",
        'start' => $validatedData['fecha_cita'],
        'end' => $validatedData['fecha_cita'],
        'color' => '#3F99F5',
        'user_id' => $user ? $user->id : null,
        'servicio_id' => $validatedData['servicio_id'],
    ]);

    return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
}
    public function show(Cita $cita) {
        return view('cita_show', ['cita' => $cita]);
    }
public function ocultar($id)
{
    $cita = Cita::findOrFail($id);
    $cita->visible = false;
    $cita->save();

    return response()->json(['success' => true]);
}
 public function actualizarEstado(Cita $cita)
    {
        $cita->update(['estado' => 'Atendido']);
        return redirect()->route('citas.index')->with('success', 'cita marcada como atendida.');
    }
    public function edit($id)
{
    // Obtener la cita que se está editando
    $cita = Cita::findOrFail($id);

    // Obtener las horas disponibles (esto dependerá de tu lógica de negocio)
    $horas = $this->obtenerHorasDisponibles($cita);
    $pacientes = Paciente::all();
    $propietarios = Propietario::all();
    $servicios = Servicio::all();

    return view('cita_edit', [
        'cita' => $cita,
        'horas' => $horas,
        'pacientes' => $pacientes,
        'propietarios' => $propietarios,
        'servicios' => $servicios
    ]);
}

private function obtenerHorasDisponibles($cita)
{
    // Aquí puedes agregar tu lógica para obtener las horas disponibles.
    // Esto podría incluir una lógica similar a la que tienes en el JavaScript para calcular las horas disponibles.
    // Ejemplo básico:
    return [
        '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00',
        '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00'
    ];
}

    

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'propietario_id' => 'required|exists:propietarios,id',
        'fecha_cita' => 'required|date|after_or_equal:today',
        'hora_cita' => 'required|string|max:255',
        'servicio_id' => 'required|exists:servicios,id',
        'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
    ]);

    // Buscar la cita ANTES de actualizar
    $cita = Cita::findOrFail($id);

    // Buscar el ticket relacionado con los datos ANTERIORES
    $ticket = TicketVirtual::where('fecha_cita', $cita->fecha_cita)
                           ->where('hora_cita', $cita->hora_cita)
                           ->where('servicio_id', $cita->servicio_id)
                           ->first();

    // Actualizar la cita con los nuevos datos
    $cita->update($validatedData);

    // Datos relacionados
    $paciente = Paciente::find($validatedData['paciente_id']);
    $servicio = Servicio::find($validatedData['servicio_id']);
    $user = \Illuminate\Support\Facades\Auth::user();

    // Actualizar el ticket si existe
    if ($ticket) {
        $ticket->update([
            'nombre_mascota' => $paciente->nombre,
            'tipo_mascota' => $paciente->raza ?? 'N/D',
            'fecha_cita' => $validatedData['fecha_cita'],
            'hora_cita' => $validatedData['hora_cita'],
            'title' => "{$validatedData['hora_cita']} - {$servicio->nombre}",
            'start' => $validatedData['fecha_cita'],
            'end' => $validatedData['fecha_cita'],
            'color' => '#3F99F5',
            'user_id' => $user ? $user->id : null,
            'servicio_id' => $validatedData['servicio_id'],
        ]);
    } else {
        // Crear nuevo ticket si no se encontró
        TicketVirtual::create([
            'nombre_mascota' => $paciente->nombre,
            'tipo_mascota' => $paciente->raza ?? 'N/D',
            'fecha_cita' => $validatedData['fecha_cita'],
            'hora_cita' => $validatedData['hora_cita'],
            'title' => "{$validatedData['hora_cita']} - {$servicio->nombre}",
            'start' => $validatedData['fecha_cita'],
            'end' => $validatedData['fecha_cita'],
            'color' => '#3F99F5',
            'user_id' => $user ? $user->id : null,
            'servicio_id' => $validatedData['servicio_id'],
        ]);
    }

    return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
}


    public function destroy(Cita $cita) {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada.');
    }
}

