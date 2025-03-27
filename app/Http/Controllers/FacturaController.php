<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Paciente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('paciente')->get();
        return view('factura_index', compact('facturas'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        return view('factura_create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'total' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'estado' => 'required|in:Pagado,Pendiente',
        ]);

        Factura::create($request->all());

        return redirect()->route('facturas.index')->with('success', 'Factura registrada correctamente');
    }

    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        $pacientes = Paciente::all();
        return view('factura_edit', compact('factura', 'pacientes'));
    }

    public function update(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);

        $factura->update($request->all());

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada correctamente');
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada correctamente');
    }
}
