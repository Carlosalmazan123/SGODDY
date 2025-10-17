<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller; // Ensure the correct Controller class is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:inventario.index")->only("index");
        $this->middleware("can:inventario.create")->only("create", "store");
        $this->middleware("can:inventario.edit")->only("edit", "update");
        $this->middleware("can:inventario.delete")->only("destroy");
    }
    public function index()
    {
        $inventarios = Inventario::with('producto')->paginate(6);
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
            'stock' => 'required|numeric|min:0.1',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'descripcion' => 'nullable|string',
            'fecha_movimiento' => 'nullable|date',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->stock;
        $stock_anterior = $producto->stock_actual; // antes del movimiento
        $stock_nuevo = $stock_anterior + $cantidad;            // se calcula según tipo

        // 🧠 Lógica según tipo de movimiento
        switch ($request->tipo_movimiento) {
            case 'entrada':
                $stock_nuevo = $stock_anterior + $cantidad;
                break;

            case 'salida':
                if ($cantidad > $stock_anterior) {
                    return back()->withErrors([
                        'stock' => '❌ No hay suficiente stock disponible. 
                        Stock actual: ' . $stock_anterior
                    ])->withInput();
                }
                $stock_nuevo = $stock_anterior - $cantidad;
                break;

            case 'ajuste':
                // En ajuste, el valor ingresado representa el nuevo stock total
                $stock_nuevo = $cantidad;
                $cantidad = abs($stock_nuevo - $stock_anterior);
                break;
        }

        // 🧾 Registrar el movimiento
       Inventario::create([
    'producto_id' => $producto->id,
    'stock' => $cantidad,
    'tipo_movimiento' => $request->tipo_movimiento,
    'descripcion' => $request->descripcion,
    'fecha_movimiento' => now(),
    'usuario_id' => Auth::id(),
    'stock_anterior' => $stock_anterior,
    'stock_nuevo' => $stock_nuevo,
]);
        // 💾 Actualizar el stock del producto
        $producto->update(['stock_actual' => $stock_nuevo]);

        return redirect()->route('inventario.index')->with('success', 'Movimiento registrado y stock actualizado correctamente.');
    }
    

    public function edit(Inventario $inventario)
    {
        $productos = Producto::all();
        return view('inventario_edit', compact('inventario', 'productos'));
    }
public function reportePDF(Request $request)
{
    $fecha = $request->input('fecha');

    $inventario = Inventario::with('producto')
                    ->when($fecha, function($query) use ($fecha) {
                        $query->whereDate('fecha_movimiento', $fecha);
                    })
                    ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('inventario_show', compact('inventario', 'fecha'))
             ->setPaper('a4', 'landscape');

    return $pdf->stream('reporte_inventario_' . $fecha . '.pdf');
}

  public function update(Request $request, Inventario $inventario)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'stock' => 'required|numeric|min:0.1',
        'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
        'descripcion' => 'nullable|string',
    ]);

    $producto = Producto::findOrFail($request->producto_id);
    $cantidad = $request->stock;

    // Guardamos el stock actual antes de revertir el movimiento anterior
    $stock_actual = $producto->stock_actual;

    /**
     * 🧩 1. REVERTIR EL MOVIMIENTO ANTERIOR
     * Devolvemos el stock del producto al estado anterior antes de aplicar el nuevo cambio.
     */
    switch ($inventario->tipo_movimiento) {
        case 'entrada':
            $stock_actual -= $inventario->stock; // Restamos lo que antes se había sumado
            break;
        case 'salida':
            $stock_actual += $inventario->stock; // Sumamos lo que antes se había restado
            break;
        case 'ajuste':
            $stock_actual = $inventario->stock_anterior; // Volvemos al valor previo del ajuste
            break;
    }

    /**
     * 🧮 2. APLICAR EL NUEVO MOVIMIENTO
     */
    switch ($request->tipo_movimiento) {
        case 'entrada':
            // Sumar las nuevas unidades al stock ya revertido
            $stock_nuevo = $stock_actual + $cantidad;
            break;

        case 'salida':
            // Verificar que haya suficiente stock
            if ($cantidad > $stock_actual) {
                return back()->withErrors([
                    'stock' => 'No hay suficiente stock disponible para esta salida. 
                    Stock actual: ' . number_format($stock_actual, 2)
                ])->withInput();
            }
            $stock_nuevo = $stock_actual - $cantidad;
            break;

        case 'ajuste':
            // Ajuste directo al nuevo valor físico
            $stock_nuevo = $cantidad;
            break;
    }

    /**
     * 📝 3. ACTUALIZAR EL REGISTRO DE INVENTARIO
     */
    $inventario->update([
        'producto_id' => $producto->id,
        'stock' => $cantidad,
        'tipo_movimiento' => $request->tipo_movimiento,
        'descripcion' => $request->descripcion,
        'fecha_movimiento' => now(),
        'usuario_id' => Auth::id(),
        'stock_anterior' => $stock_actual,
        'stock_nuevo' => $stock_nuevo,
    ]);

    /**
     * 💾 4. ACTUALIZAR EL PRODUCTO
     */
    $producto->update(['stock_actual' => $stock_nuevo]);

    
    return redirect()->route('inventario.index')
        ->with('success', 'Movimiento actualizado y stock recalculado correctamente.');
}

     public function destroy(Inventario $inventario)
    {
        $producto = $inventario->producto;

        if ($inventario->tipo_movimiento === 'entrada') {
            $producto->stock_actual -= $inventario->stock;
        } elseif ($inventario->tipo_movimiento === 'salida') {
            $producto->stock_actual += $inventario->stock;
        } elseif ($inventario->tipo_movimiento === 'ajuste') {
            $producto->stock_actual = $inventario->stock_anterior;
        }

        $producto->save();
        $inventario->delete();

        return redirect()->route('inventario.index')->with('success', 'Movimiento eliminado y stock revertido correctamente.');
    }
    public function deleted()
    {
        $deletedInventarios = Inventario::onlyTrashed()->with('producto')->paginate(6);
        return view('inventario_elim', compact('deletedInventarios'));
    }
    public function restore($id)
    {
        $inventario = Inventario::onlyTrashed()->findOrFail($id);
        $producto = $inventario->producto;

        // Reaplicar el movimiento al restaurar
        if ($inventario->tipo_movimiento === 'entrada') {
            $producto->stock_actual += $inventario->stock;
        } elseif ($inventario->tipo_movimiento === 'salida') {
            if ($inventario->stock > $producto->stock_actual) {
                return redirect()->back()->with('error', 'No se puede restaurar este movimiento de salida porque excede el stock actual del producto.');
            }
            $producto->stock_actual -= $inventario->stock;
        } elseif ($inventario->tipo_movimiento === 'ajuste') {
            $producto->stock_actual = $inventario->stock_nuevo;
        }

        $producto->save();
        $inventario->restore();

        return redirect()->back()->with('success', 'Movimiento restaurado y stock actualizado correctamente.');
    }
    public function forceDelete($id)
    {
        $inventario = Inventario::onlyTrashed()->findOrFail($id);
        $inventario->forceDelete();
        return redirect()->back()->with('success', 'Movimiento eliminado permanentemente.');
    }
    public function forceDeleteAll()
    {
        $inventarios = Inventario::onlyTrashed()->get();
        foreach ($inventarios as $inventario) {
            $inventario->forceDelete();
        }
        return redirect()->back()->with('success', 'Todos los movimientos eliminados permanentemente.');
    }
}
