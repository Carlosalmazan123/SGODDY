<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialClinico;
use App\Models\Paciente;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class HistorialClinicoController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:historial.create")->only("create", "store");
        $this->middleware("can:historial.edit")->only("edit", "update");
        $this->middleware("can:historial.delete")->only("destroy");
    }
    public function index(Paciente $paciente)
{
    // traer solo los historiales del paciente (paginación recomendable)
    $historial = $paciente->historial()
                           ->orderBy('created_at', 'desc')
                           ->paginate(10); // o ->get() si no quieres paginar

    return view('historial_index', compact('paciente', 'historial'));
}

    public function validarForm(Request $request)
    {
        return $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'anamnesis' => 'required|string',
            'diagnostico' => 'required|string',
            'examen' => 'required|string',
            "fecha" => "required|array",
            "fecha.*" => "required|date",
            "tratamiento" => "required|array",
            "tratamiento.*" => "required|string",
            "observaciones" => "nullable|array",
            "observaciones.*" => "nullable|string",
         
        ]);
    }

    public function create($pacienteId)
    {
         // Esto te mostrará el valor del pacienteId
        $paciente = Paciente::findOrFail($pacienteId);
        return view('historial_create', compact('paciente'));
    }
    public function store(Request $request, $pacienteId)
{
    // Validación de los campos
    $request->validate([
        'anamnesis' => 'required|string',
        'diagnostico' => 'required|string',
        'examen' => 'nullable|string',
        'tratamiento' => 'required|array',
        'observaciones' => 'nullable|array',
        'fecha' => 'required|array',
    ]);
    // Crear una nueva instancia de HistorialClinico
    $historial = new HistorialClinico();
    $historial->anamnesis = $request->anamnesis;
    $historial->diagnostico = $request->diagnostico;
    $historial->examen = $request->examen;
    // Asignar los datos directamente, Laravel convertirá los arrays a JSON si es necesario
    $historial->tratamiento = $request->tratamiento;
    $historial->observaciones = $request->observaciones;
    $historial->fecha = $request->fecha;
    // Asignar el paciente_id
    $historial->paciente_id = $pacienteId;
    // Guardar en la base de datos
    $historial->save();
    // Redirigir al paciente con un mensaje de éxito
    return redirect()->route('pacientes.show', $pacienteId)->with('success', 'Historial guardado correctamente.');
}

    

public function show($id)
{
    $historial = HistorialClinico::with('paciente.relPropietario')->findOrFail($id);
    $paciente = $historial->paciente;

    return view('historial_show', compact('historial', 'paciente'));
}



public function generarReporte(Paciente $paciente, HistorialClinico $historial)
{
    return Pdf::loadView('historial_reporte', compact('paciente', 'historial'))
              ->setPaper('a4', 'portrait')
              ->stream('Historial_Clinico_'.$paciente->nombre.'.pdf');
}
public function edit($pacienteId, $historialId)
{
    // Buscar paciente e historial
    $paciente = Paciente::findOrFail($pacienteId);
    $historial = HistorialClinico::findOrFail($historialId);
    
    // Retornar vista de edición
    return view('historial_edit', compact('paciente', 'historial'));
}

public function update(Request $request, $pacienteId, $historialId)
{
    // Validación de los campos
    $request->validate([
        'anamnesis' => 'required|string',
        'diagnostico' => 'required|string',
        'examen' => 'nullable|string',
        'tratamiento' => 'required|array',
        'observaciones' => 'nullable|array',
        'fecha' => 'required|array',
    ]);

    // Buscar historial clínico
    $historial = HistorialClinico::findOrFail($historialId);
    
    // Actualizar los datos
    $historial->anamnesis = $request->anamnesis;
    $historial->diagnostico = $request->diagnostico;
    $historial->examen = $request->examen;
    $historial->tratamiento = $request->tratamiento;
    $historial->observaciones = $request->observaciones;
    $historial->fecha = $request->fecha;

    // Guardar cambios
    $historial->save();

    // Redirigir con mensaje de éxito
    return redirect()->route('pacientes.show', $pacienteId)->with('success', 'Historial actualizado correctamente.');
}


    public function destroy(Paciente $paciente, HistorialClinico $historial)
{
    $historial->delete();

    return redirect()->route('historial.index', $paciente->id)
        ->with('success', 'Historial clínico eliminado correctamente.');
}

    public function deleted(){
        $deletedHistoriales = HistorialClinico::onlyTrashed()->paginate(10);
        $paciente=Paciente::with('historial')->get();

        return view('historial_elim', compact('deletedHistoriales', 'paciente'));
    }
    public function restore( Paciente $paciente , $id){
        $historial = HistorialClinico::onlyTrashed()->findOrFail($id);
        $paciente = $historial->paciente;
        $historial->restore();
        return redirect()->route('historial.deleted',$paciente->id)->with('success', 'Historial clínico restaurado correctamente.');
    }
    public function forceDelete($id){
        $historial = HistorialClinico::onlyTrashed()->findOrFail($id);
        $historial->forceDelete();
        return redirect()->route('historial.deleted')->with('success', 'Historial clínico eliminado permanentemente.');
    }
    public function forceDeleteAll(){
        $historiales = HistorialClinico::onlyTrashed()->get();
        foreach($historiales as $historial){
            $historial->forceDelete(); 
        }
        return redirect()->route('historial.deleted')->with('success', 'Todos los historiales clínicos eliminados permanentemente.');
    }
}
