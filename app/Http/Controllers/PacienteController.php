<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    public function index() {
        return view('paciente_index', ['pacientes' => Paciente::all()]);
    }

    public function create() {
        $pacientes=Paciente::all();
        $propietarios=Propietario::all();
        return view('paciente_create',[ "propietarios"=>$propietarios,"pacientes"=>$pacientes]);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string',
            'especie' => 'required|string',
            'raza' => 'nullable|string',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string',
            'color' => 'required|string',
            'peso' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'propietario_id' => 'nullable|exists:propietarios,id',
            'nuevo_nombre' => 'nullable|string|required_if:propietario_id,null',
            'nuevo_apellido' => 'nullable|string|required_if:propietario_id,null',
            'nuevo_telefono' => 'nullable|string|required_if:propietario_id,null|unique:propietarios,telefono',
            'nuevo_direccion' => 'nullable|string',
        ]);
    
        // Si se está registrando un nuevo propietario
        if ($request->filled('nuevo_nombre') && $request->filled('nuevo_apellido') && $request->filled('nuevo_telefono')) {
            $propietario = Propietario::create([
                'nombre' => $request->nuevo_nombre,
                'apellido' => $request->nuevo_apellido,
                'telefono' => $request->nuevo_telefono,
                'direccion' => $request->nuevo_direccion,
            ]);
            $propietario_id = $propietario->id;
        } else {
            $propietario_id = $request->propietario_id;
        }
    
        // Crear el paciente (pero no aún guardar la imagen)
        $paciente = new Paciente();
        $paciente->nombre = $request->nombre;
        $paciente->especie = $request->especie;
        $paciente->raza = $request->raza;
        $paciente->edad = $request->edad;
        $paciente->sexo = $request->sexo;
        $paciente->color = $request->color;
        $paciente->peso = $request->peso;
        $paciente->propietario_id = $propietario_id;
    
        // Si se sube una nueva imagen
        if ($request->hasFile('imagen')) {
            // Obtener la extensión del archivo
            $extension = $request->file('imagen')->getClientOriginalExtension();
    
            // Generar un nuevo nombre basado en la fecha y hora
            $imageName = now()->format('Ymd_His') . '.' . $extension;
    
            // Guardar la nueva imagen en storage/app/public/pacientes con el nuevo nombre
            $imagePath = $request->file('imagen')->storeAs('pacientes', $imageName, 'public');
    
            // Guardar la ruta en el modelo del paciente
            $paciente->imagen = $imagePath;
        }
    
        // Guardar el paciente con el propietario asociado y la imagen si existe
        $paciente->save();
    
        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado exitosamente.');
    }
    


    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('paciente_show', compact('paciente'));
    }

    public function edit($id)
{
    $paciente = Paciente::findOrFail($id);
    $propietarios = Propietario::all(); // Obtener todos los propietarios
    
    return view('paciente_edit', compact('paciente', 'propietarios'));
}

public function update(Request $request, $id)
{
    $paciente = Paciente::findOrFail($id);
    
    $request->validate([
        'nombre' => 'required|string',
        'especie' => 'required|string',
        'raza' => 'nullable|string',
        'edad' => 'required|integer|min:0',
        'sexo' => 'required|string',
        'color' => 'required|string',
        'peso' => 'required|numeric',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'propietario_id' => 'nullable|exists:propietarios,id'
    ]);

    // Actualizar los datos del paciente
    $paciente->update([
        'nombre' => $request->nombre,
        'especie' => $request->especie,
        'raza' => $request->raza,
        'edad' => $request->edad,
        'sexo' => $request->sexo,
        'color' => $request->color,
        'peso' => $request->peso,
        'propietario_id' => $request->propietario_id
    ]);
    
    // Manejo de la imagen
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen anterior si existe
        if ($paciente->imagen) {
            Storage::disk('public')->delete($paciente->imagen);
        }
 // Obtener la extensión del archivo
        $extension = $request->file('imagen')->getClientOriginalExtension();
     
 // Generar un nuevo nombre basado en la fecha y hora
        $imageName = now()->format('Ymd_His') . '.' . $extension;

 // Guardar la nueva imagen en storage/app/public/users con el nuevo nombre
         $imagePath = $request->file('imagen')->storeAs('pacientes', $imageName, 'public');

        $paciente->imagen = $imagePath;
        
    }
    $paciente->save();

    return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
}

public function destroy(Paciente $paciente) {
    // Eliminar la imagen del almacenamiento si existe
    if ($paciente->imagen) {
        Storage::disk('public')->delete($paciente->imagen);
    }

    // Eliminar el paciente de la base de datos
    $paciente->delete();

    return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado exitosamente.');
}

}
