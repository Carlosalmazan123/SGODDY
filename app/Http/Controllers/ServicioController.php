<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // Mostrar todos los servicios
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicio_index', compact('servicios'));
    }

    // Mostrar formulario para crear un nuevo servicio
    public function create()
    {
        return view('servicio_create');
    }

    // Almacenar un nuevo servicio
    public function store(Request $request)
{
    // Asignamos un valor por defecto a "activo" si no se envía
    $activo = $request->has('activo') ? true : false;

    // Validamos los demás campos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric',
        'duracion' => 'required|date_format:H:i',
    ]);

    // Creamos el servicio con el valor de "activo"
    Servicio::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'duracion' => $request->duracion,
        'activo' => $activo, // Asignamos el valor correcto de "activo"
    ]);

    return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
}

    // Mostrar el formulario para editar un servicio
    public function edit(Servicio $servicio)
    {
        return view('servicio_edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
{
    // Asignamos un valor por defecto a "activo" si no se envía
    $activo = $request->has('activo') ? true : false;

    // Validamos los demás campos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric',
        'duracion' => 'required|date_format:H:i:s',
    ]);

    // Actualizamos el servicio con el valor de "activo"
    $servicio->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'duracion' => $request->duracion,
        'activo' => $activo, // Asignamos el valor correcto de "activo"
    ]);

    return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente.');
}

    // Eliminar un servicio
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}
