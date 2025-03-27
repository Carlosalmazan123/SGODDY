<?php
namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;

class PropietarioController extends Controller
{
    public function index()
    {
        $propietarios = Propietario::all();
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
        ]);

        Propietario::create($request->all());

        return redirect()->route('propietarios.index')->with('success', 'Propietario registrado correctamente.');
    }

    public function show(Propietario $propietario)
    {
        return view('propietario_show', compact('propietario'));
    }

    public function edit(Propietario $propietario)
    {
        return view('propietario_edit', compact('propietario'));
    }

    public function update(Request $request, Propietario $propietario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:15|unique:propietarios,telefono,' . $propietario->id,
            'email' => 'nullable|email|unique:propietarios,email,' . $propietario->id,
            'direccion' => 'nullable|string',
        ]);

        $propietario->update($request->all());

        return redirect()->route('propietarios.index')->with('success', 'Propietario actualizado correctamente.');
    }

    public function destroy(Propietario $propietario)
    {
        $propietario->delete();
        return redirect()->route('propietarios.index')->with('success', 'Propietario eliminado correctamente.');
    }
}
