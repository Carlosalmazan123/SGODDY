<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:proveedor.index")->only("index");
        $this->middleware("can:proveedor.create")->only("create", "store");
        $this->middleware("can:proveedor.edit")->only("edit", "update");
        $this->middleware("can:proveedor.delete")->only("destroy");
    }
    public function index()
    {
        $proveedores = Proveedor::paginate(6);
        return view('proveedor_index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedor_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit($id)

    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedor_edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy( $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
    public function deleted(){
        $deletedProveedores = Proveedor::onlyTrashed()->paginate(6);
        return view('proveedor_elim', compact('deletedProveedores'));
    }
    public function restore($id){
        $proveedor = Proveedor::onlyTrashed()->findOrFail($id);
        $proveedor->restore();
        return redirect()->back()->with('success', 'Proveedor restaurado correctamente.');
    }   
    public function forceDelete($id)
    {
        $proveedor = Proveedor::onlyTrashed()->findOrFail($id);
        $proveedor->forceDelete();

        return redirect()->back()->with('success', 'Proveedor eliminado permanentemente.');
    }
    public function forceDeleteAll()
    {
        $proveedores = Proveedor::onlyTrashed()->get();
        foreach ($proveedores as $proveedor) {
            $proveedor->forceDelete(); 
        }
        return redirect()->back()->with('success', 'Todos los proveedores eliminados fueron eliminados permanentemente.');
    }
}
