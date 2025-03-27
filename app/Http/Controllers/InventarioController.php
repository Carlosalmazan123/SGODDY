<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto')->get();
        return view('inventario_index', compact('inventarios'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('inventario_create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'descripcion' => 'nullable|string',
        ]);

        Inventario::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'tipo_movimiento' => $request->tipo_movimiento,
            'descripcion' => $request->descripcion,
            'fecha_movimiento' => now(),
            'usuario_id' => auth()->id(), // Suponiendo que usas autenticación
        ]);

        return redirect()->route('inventario.index')->with('success', 'Movimiento de inventario registrado exitosamente.');
    }

    public function show(Inventario $inventario)
    {
        return view('inventario_show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        $productos = Producto::all();
        return view('inventario_edit', compact('inventario', 'productos'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'descripcion' => 'nullable|string',
        ]);

        $inventario->update([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'tipo_movimiento' => $request->tipo_movimiento,
            'descripcion' => $request->descripcion,
            'fecha_movimiento' => now(),
            'usuario_id' => auth()->id(),
        ]);

        return redirect()->route('inventario.index')->with('success', 'Movimiento de inventario actualizado exitosamente.');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Movimiento de inventario eliminado.');
    }
}
