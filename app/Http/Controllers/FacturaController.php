<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Inventario;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Servicio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller; // Ensure the base Controller is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:factura.index")->only("index");
        $this->middleware("can:factura.create")->only("create", "store");
        $this->middleware("can:factura.edit")->only("edit", "update");
        $this->middleware("can:factura.delete")->only("destroy");
    }
   public function index()
{
    $facturas = Factura::with([ 'producto','user'])->latest()->paginate(6);

    return view('factura_index', compact('facturas'));
}
  public function show($id)
{
    $factura = Factura::with('user')->findOrFail($id);

    // Obtener los detalles relacionados (productos, cantidades y subtotales)
    $detalles = FacturaDetalle::where('factura_id', $id)->get();

    // Calcular el total sumando los subtotales de los detalles
    $total = $detalles->sum('subtotal');

    return view('factura_show', compact('factura', 'detalles', 'total'));
}
public function generarPDF($id)
{
    $factura = Factura::with('user')->findOrFail($id);
    $detalles = FacturaDetalle::where('factura_id', $id)->get();
    $total = $detalles->sum('subtotal');

    $pdf = Pdf::loadView('factura_show', compact('factura', 'detalles', 'total'));
    return $pdf->stream("recibo_{$factura->id}.pdf");
}
public function create()
{
    $productos = Producto::with('inventarios')->get();
    $servicios = Servicio::all();
    $factura = Factura::all();

    // Armamos el JSON de productos incluyendo su stock actual
    $productosJson = $productos->map(fn($p) => [
        'id' => $p->id,
        'nombre' => $p->nombre,
        'precio' => $p->precio,
        'check' => $p->check,
        'stock' => $p->stock, // ✅ stock dinámico (entradas - salidas)
    ])->toJson();

    $serviciosJson = $servicios->map(fn($s) => [
        'id' => $s->id,
        'nombre' => $s->nombre,
        'precio' => $s->precio,
        'check' => 0,
    ])->toJson();

    return view('factura_create', compact('productos', 'servicios', 'factura', 'productosJson', 'serviciosJson'));
}

public function store(Request $request)
{
    $request->validate([
        'item_id' => 'required|array',
        'item_id.*' => 'required|string', // "p-3" o "s-2"
        'cantidad' => 'required|array',
        'cantidad.*' => 'required|numeric|min:0.01',
        'subtotal' => 'required|array',
        'subtotal.*' => 'required|numeric|min:0',
        'fecha' => 'nullable|date'
    ]);

    DB::beginTransaction();
    try {
        $total = array_sum($request->subtotal);

        // Crear la factura
        $factura = Factura::create([
            'fecha' => $request->fecha ?? now(),
            'total' => $total,
            'user_id' => auth()->id(),
        ]);

        foreach ($request->item_id as $index => $itemValue) {
            $cantidad = floatval($request->cantidad[$index] ?? 0);
            $subtotal = floatval($request->subtotal[$index] ?? 0);

            $producto_id = null;
            $servicio_id = null;

            // Caso: producto
            if (str_starts_with($itemValue, 'p-')) {
                $producto_id = (int) str_replace('p-', '', $itemValue);
                $producto = Producto::findOrFail($producto_id);

                // Verificar stock suficiente
                if ($producto->stock_actual < $cantidad) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }

                // Guardar valores de stock
                $stockAnterior = $producto->stock_actual;
                $stockNuevo = $stockAnterior - $cantidad;

                // Actualizar stock actual del producto
                $producto->update([
                    'stock_actual' => $stockNuevo
                ]);

                // Registrar salida en inventario
                Inventario::create([
                    'producto_id' => $producto_id,
                    'stock_anterior' => $stockAnterior,
                    'stock' => $cantidad,
                    'stock_nuevo' => $stockNuevo,
                    'stock_actual' => $stockNuevo,
                    'tipo_movimiento' => 'Salida',
                    'descripcion' => "Venta asociada a factura #{$factura->id}",
                    'usuario_id' => auth()->id(),
                ]);
            }

            // Caso: servicio
            elseif (str_starts_with($itemValue, 's-')) {
                $servicio_id = (int) str_replace('s-', '', $itemValue);
                $servicio = Servicio::findOrFail($servicio_id);
            }

            // Guardar detalle
            FacturaDetalle::create([
                'factura_id' => $factura->id,
                'producto_id' => $producto_id,
                'precio' => $producto_id ? $producto->precio : ($servicio_id ? $servicio->precio : 0),
                 // precio según si es producto o servicio
                'servicio_id' => $servicio_id,
                'cantidad'   => $cantidad,
                'subtotal'   => $subtotal,
            ]);
        }

        DB::commit();
        return redirect()->route('facturas.index')->with('success', 'Venta realizada correctamente.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al crear la venta: ' . $e->getMessage());
    }
}


public function reportePDF(Request $request)
    {
        $from = $request->query('fecha_desde');
        $to   = $request->query('fecha_hasta');

        $query = Factura::with([
         // factura->paciente->propietario
            'detalles.producto'         // factura->detalles->producto
        ]);

        if ($from && $to) {
            // rango inclusive
            $query->whereBetween('fecha', [$from, $to]);
            $periodo = "$from a $to";
        } elseif ($from) {
            $query->whereDate('fecha', $from);
            $periodo = $from;
        } else {
            // por defecto: hoy
            $hoy = now()->toDateString();
            $query->whereDate('fecha', $hoy);
            $periodo = $hoy;
        }

        $facturas = $query->orderBy('fecha', 'desc')->get();

        // Calcular totales del periodo
        $totalVentas = $facturas->sum('total');
        $cantidadFacturas = $facturas->count();

        $pdf = Pdf::loadView('factura_reporte', compact('facturas', 'totalVentas', 'cantidadFacturas', 'periodo'))
                  ->setPaper('a4', 'portrait');

        // Abrir en el navegador (stream). Para forzar descarga: ->download(...)
        return $pdf->stream("reporte_ventas_{$periodo}.pdf");
    }

  public function edit($id)
{
    $factura = Factura::with('detalles.producto', 'detalles.servicio')->findOrFail($id);
    $productos = Producto::all();
    $servicios = Servicio::all();

    return view('factura_edit', compact('factura', 'productos', 'servicios'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'item_id' => 'required|array',
        'item_id.*' => 'required|string',
       'cantidad' => 'required|array',
        'cantidad.*' => 'required|numeric|min:0.01', // permitimos decimales
        'subtotal' => 'required|array',
        'subtotal.*' => 'numeric|min:0',
        'fecha' => 'nullable|date',
    ]);

    DB::beginTransaction();
    try {
        $factura = Factura::findOrFail($id);

        // Actualizar datos de la factura
        $total = array_sum($request->subtotal);
        $factura->update([
            'fecha' => $request->fecha ?? now(),
            'total' => $total,
        ]);

        // Borrar detalles anteriores
        $factura->detalles()->delete();

        // Registrar de nuevo los detalles
        foreach ($request->item_id as $index => $itemValue) {
            if (empty($itemValue)) {
                throw new \Exception("El item en la fila " . ($index + 1) . " no fue seleccionado.");
            }

            $cantidad = $request->cantidad[$index] ?? 0;
            $subtotal = $request->subtotal[$index] ?? 0;

            $producto_id = null;
            $servicio_id = null;

            if (str_starts_with($itemValue, 'p-')) {
                $producto_id = (int) str_replace('p-', '', $itemValue);

                $producto = Producto::findOrFail($producto_id);
                if ($producto->stock < $cantidad) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }

                Inventario::create([
                    'producto_id' => $producto_id,
                    'stock' => $cantidad,
                    'tipo_movimiento' => 'Salida',
                    'descripcion' => "Edición de factura #{$factura->id}",
                    'usuario_id' => auth()->id(),
                ]);
            } elseif (str_starts_with($itemValue, 's-')) {
                $servicio_id = (int) str_replace('s-', '', $itemValue);
            }

            FacturaDetalle::create([
                'factura_id' => $factura->id,
                'producto_id' => $producto_id,
                'servicio_id' => $servicio_id,
                'cantidad'   => $cantidad,
                'subtotal'   => $subtotal,
            ]);
        }

        DB::commit();
        return redirect()->route('facturas.index')->with('success', 'Venta actualizada correctamente.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al actualizar la Venta: ' . $e->getMessage());
    }
}
    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Venta eliminada correctamente');
    }
    public function deleted(){
        $deletedFacturas = Factura::onlyTrashed()->paginate(6);
        return view('factura_elim', compact('deletedFacturas'));
    }
    public function restore($id){
        $factura = Factura::withTrashed()->findOrFail($id);
        if ($factura->trashed()) {
            $factura->restore();
            return redirect()->back()->with('success', 'Venta restaurada correctamente.');
        }
        return redirect()->route('facturas.index')->with('info', 'La venta no está eliminada.');    
    }
    public function forceDelete($id){
        $factura = Factura::withTrashed()->findOrFail($id);
        if ($factura->trashed()) {
            $factura->forceDelete();
            return redirect()->back()->with('success', 'Venta eliminada permanentemente.');
        }
        return redirect()->back()->with('info', 'La venta no está eliminada.');      
    }
    public function forceDeleteAll()
    {
        $deletedFacturas = Factura::onlyTrashed()->get();      
        foreach ($deletedFacturas as $factura) {
            $factura->forceDelete();
        }
        return redirect()->back()->with('success', 'Todas las ventas eliminadas permanentemente.');  
    }   
}
