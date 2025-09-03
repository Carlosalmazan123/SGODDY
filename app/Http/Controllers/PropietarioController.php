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
            'email' => 'nullable|email|unique:propietarios',
            'direccion' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'correo'=>'nullable|string',
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

    public function destroy(Propietario $propietario)
    {
        $propietario->delete();
        return redirect()->route('propietarios.index')->with('success', 'Propietario eliminado correctamente.');
    }
}
