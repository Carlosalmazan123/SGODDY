<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function __construct(){
        $this->middleware("can:producto.index")->only("index");
        $this->middleware("can:producto.create")->only("create","store");
        $this->middleware("can:producto.edit")->only("edit","update");
        $this->middleware("can:producto.delete")->only("destroy");
    }
    public function index()
    {
        $productos = Producto::paginate(6);
        return view('producto_index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('producto_create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
       
         
            'fecha_vencimiento' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return view('producto_show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('producto_edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
         
         
            'fecha_vencimiento' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validatedData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
