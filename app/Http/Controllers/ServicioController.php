<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:servicio.index")->only("index");
        $this->middleware("can:servicio.create")->only("create", "store");
        $this->middleware("can:servicio.edit")->only("edit", "update");
        $this->middleware("can:servicio.delete")->only("destroy");
    }
    // Mostrar todos los servicios
    public function index()
    {
        $servicios = Servicio::paginate(6);
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
        'duracion' => 'required|integer|min:1',
    ]);
    $minutos = (int) $request->duracion;
    $horas = floor($minutos / 60);
    $mins = $minutos % 60;
    $duracion = sprintf('%02d:%02d:00', $horas, $mins);


    // Creamos el servicio con el valor de "activo"
    Servicio::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'duracion' => $duracion,
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
        'duracion' => 'required|integer|min:1',
    ]);
    // Convertir minutos a HH:MM:SS
    $minutos = (int) $request->duracion;
    $horas = floor($minutos / 60);
    $mins = $minutos % 60;
    $duracion = sprintf('%02d:%02d:00', $horas, $mins);

    // Actualizamos el servicio con el valor de "activo"
    $servicio->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'duracion' => $duracion,
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
    public function obtenerDuracion($id)
{
    $servicio = Servicio::findOrFail($id);
    return response()->json([
        'duracion' => $servicio->duracion // formato: "HH:MM"
    ]);
}

}
