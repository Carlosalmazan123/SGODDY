<?php
namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class PropietarioController extends Controller
{
    public function __construct(){
        $this->middleware("can:propietario.index")->only("index");
        $this->middleware("can:propietario.create")->only("create","store");
        $this->middleware("can:propietario.edit")->only("edit","update");
        $this->middleware("can:propietario.delete")->only("destroy");
    }
 public function index()
{
    $propietarios = Propietario::with('relPaciente')->paginate(6);
    return view('propietario_index', compact('propietarios'));
}
    public function create()
    {
        return view('propietario_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:15|unique:propietarios',
           
            'direccion' => 'nullable|string',
            'correo'=>'required|string|email|max:255|unique:propietarios',
        ]);

        Propietario::create($request->all());

        return redirect()->route('propietarios.index')->with('success', 'Propietario registrado correctamente.');
    }

    public function show(Propietario $propietario)
    {
        return view('propietario.show', compact('propietario'));
    }

    public function edit(Propietario $propietario)
{
    // Este método carga la vista de edición, pasando el propietario seleccionado a la vista
    return view('propietario_edit', compact('propietario'));
}

public function update(Request $request, Propietario $propietario)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'telefono' => 'required|string|max:255',
        'direccion' => 'nullable|string',
    ]);

    // Actualizar el propietario con los datos validados
    $propietario->update($validatedData);

    // Redirigir con un mensaje de éxito
    return redirect()->route('propietarios.index')->with('success', 'Propietario actualizado con éxito.');
}

    // Eliminar (Soft Delete)
   public function destroy($id)
{
    $propietario = Propietario::findOrFail($id);

    // Eliminar (soft delete) también las mascotas asociadas
    if ($propietario->pacientes()->exists()) {
        $propietario->pacientes()->delete();
    }

    $propietario->delete();

    return redirect()->back()->with('success', 'Propietario y sus mascotas eliminados correctamente.');
}

// Restaurar propietario y sus mascotas
public function restore($id)
{
    $propietario = Propietario::onlyTrashed()->findOrFail($id);

    // Restaurar el propietario
    $propietario->restore();

    // Restaurar las mascotas asociadas
    $propietario->pacientes()->onlyTrashed()->restore();

    return redirect()->back()->with('success', 'Propietario y sus mascotas restaurados correctamente.');
}


    // Eliminar permanentemente uno
    public function forceDelete($id)
    {
        $propietario = Propietario::onlyTrashed()->findOrFail($id);
         // Eliminar (soft delete) también las mascotas asociadas
    if ($propietario->pacientes()->exists()) {
        $propietario->pacientes()->forceDelete();
    }
        $propietario->forceDelete();

        return redirect()->back()->with('success', 'Propietario eliminado permanentemente.');
    }

    // Eliminar permanentemente todos los propietarios eliminados
    public function forceDeleteAll()
    {
        $deletedPropietarios = Propietario::onlyTrashed()->get();

        if ($deletedPropietarios->isEmpty()) {
            return redirect()->back()->with('error', 'No hay propietarios eliminados para borrar definitivamente.');
        }

        foreach ($deletedPropietarios as $propietario) {
             // Eliminar (soft delete) también las mascotas asociadas
    if ($propietario->pacientes()->exists()) {
        $propietario->pacientes()->forceDelete();
    }
            $propietario->forceDelete();
            
        }

        return redirect()->back()->with('success', 'Todos los propietarios eliminados fueron eliminados permanentemente.');
    }

    // Mostrar los propietarios eliminados
    public function deleted()
    {
        $deletedPropietarios = Propietario::onlyTrashed()->paginate(10);
        return view('propietario_elim', compact('deletedPropietarios'));
    }
}
