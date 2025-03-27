<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Propietario;
use App\Models\Servicio;
use App\Models\TicketVirtual;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index() {
        $citas=Cita::all();
        $pacientes=Paciente::all();
        return view('cita_index', ["citas"=>$citas,"pacientes"=>$pacientes]);
    }

    public function create() {
        $pacientes=Paciente::all();
        $propietarios=Propietario::all();
        $servicios=Servicio::all();
        $citas=Cita::all();
        return view('cita_create', ['pacientes' => $pacientes,"citas"=>$citas,"propietarios"=>$propietarios,"servicios"=>$servicios   ]);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario (opcional)
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'propietario_id' => 'required|exists:propietarios,id',
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|string',
            'servicio_id' => 'required|exists:servicios,id',
            
        ]);
    
        // Crear la cita
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'propietario_id' => $request->propietario_id,
            'fecha_cita' => $request->fecha_cita,
            'hora_cita' => $request->hora_cita,
            'servicio_id' => $request->servicio_id,
            'estado' => $request->estado,
        ]);
    
        // Redirigir a la vista 'index' después de guardar
        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente');
    }
    
    public function edit(Cita $cita) {
        return view('cita_edit', ['cita' => $cita, 'pacientes' => Paciente::all()]);
    }

    public function update(Request $request, Cita $cita) {
        $cita->update($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita actualizada.');
    }

    public function destroy(Cita $cita) {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada.');
    }
}

