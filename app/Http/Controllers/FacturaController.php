<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Inventario;
use App\Models\Paciente;
use App\Models\Producto;
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
    $facturas = Factura::with(['paciente', 'producto'])->latest()->paginate(6);

    return view('factura_index', compact('facturas'));
}
  public function show($id)
{
    $factura = Factura::with('paciente')->findOrFail($id);

    // Obtener los detalles relacionados (productos, cantidades y subtotales)
    $detalles = FacturaDetalle::where('factura_id', $id)->get();

    // Calcular el total sumando los subtotales de los detalles
    $total = $detalles->sum('subtotal');

    return view('factura_show', compact('factura', 'detalles', 'total'));
}

public function create()
{
    $pacientes = Paciente::all();
    $productos = Producto::all();
    $factura = factura::all(); // para llenar select en formulario, por ejemplo
    return view('factura_create', compact('pacientes', 'productos', 'factura'));
}
public function generarPDF($id)
{
    $factura = Factura::with('paciente')->findOrFail($id);
    $detalles = FacturaDetalle::where('factura_id', $id)->get();
    $total = $detalles->sum('subtotal');

    $pdf = Pdf::loadView('factura_show', compact('factura', 'detalles', 'total'));
    return $pdf->stream("Factura_{$factura->id}.pdf");
}
public function store(Request $request)
{
    $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'producto_id' => 'required|array',
        'producto_id.*' => 'exists:productos,id',
        'cantidad' => 'required|array',
        'cantidad.*' => 'integer|min:1',
        'subtotal' => 'required|array',
        'subtotal.*' => 'numeric|min:0',
        'fecha' => 'nullable|date',
    ]);

    DB::beginTransaction(); // Iniciamos transacción
    try {
        // Calcular total general
        

        
DB::transaction(function () use ($request) {
    // Crear la factura
    $total = array_sum($request->subtotal);
        $factura = Factura::create([
            'paciente_id' => $request->paciente_id,
            'fecha' => $request->fecha ?? now(),
            'total' => $total,
        ]);

    foreach ($request->producto_id as $index => $producto_id) {
        $producto = Producto::findOrFail($producto_id);
        $cantidadVendida = $request->cantidad[$index];

        // Verificar stock disponible
        if ($producto->stock < $cantidadVendida) {
            throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
        }

        // Registrar salida en inventario
        Inventario::create([
            'producto_id' => $producto_id,
            'stock'    => $cantidadVendida,
            'tipo_movimiento'=> 'salida',
            'descripcion' => "Venta asociada a factura #{$factura->id}",
        ]);

        // Crear detalle de la factura
        FacturaDetalle::create([
            'factura_id' => $factura->id,
            'producto_id' => $producto_id,
            'cantidad'   => $cantidadVendida,
            'subtotal'   => $request->subtotal[$index],
        ]);
    }
});
        DB::commit(); // Todo correcto, guardamos
        return redirect()->route('facturas.index')->with('success', 'Factura creada correctamente.');

    } catch (\Exception $e) {
        DB::rollback(); // Si hay error, deshacemos todo
        return back()->with('error', 'Error al crear la factura: ' . $e->getMessage());
    }
}



    public function edit($paciente_id, $factura_id)
{
    $paciente = Paciente::findOrFail($paciente_id);
    $factura = Factura::findOrFail($factura_id);
    $productos = Producto::all();

    return view('factura_edit', compact('paciente', 'factura', 'productos'));
}
  public function update(Request $request, $paciente_id, $factura_id)
{
    $request->validate([
        'producto_id.*' => 'required|exists:productos,id',
        'cantidad.*' => 'required|integer|min:1',
        'unidad.*' => 'required|string|max:255',
        'precio_unitario.*' => 'required|numeric|min:0',
        'subtotal.*' => 'required|numeric|min:0',
        'cliente.*' => 'required|string|max:255',
        'fecha.*' => 'required|date',
    ]);

    // Elimina las facturas previas relacionadas (según paciente o por grupo)
    Factura::where('paciente_id', $paciente_id)->delete();

    // Reinsertar las facturas actualizadas
    foreach ($request->producto_id as $index => $producto_id) {
        Factura::create([
            'paciente_id' => $paciente_id,
            'producto_id' => $producto_id,
            'cantidad' => $request->cantidad[$index],
            'subtotal' => $request->subtotal[$index],
            'total' => $request->subtotal[$index], // o puedes sumarlos luego si quieres un total general
        ]);
    }

    return redirect()->route('facturas.index', $paciente_id)->with('success', 'Factura(s) actualizada(s) correctamente.');
}
    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada correctamente');
    }
}
