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
    public function __construct()
    {
        $this->middleware("can:producto.index")->only("index");
        $this->middleware("can:producto.create")->only("create", "store");
        $this->middleware("can:producto.edit")->only("edit", "update");
        $this->middleware("can:producto.delete")->only("destroy");
    }

    /**
     * Listado de productos
     */
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor'])->paginate(6);
        return view('producto_index', compact('productos'));
    }

    /**
     * Formulario para crear producto
     */
    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('producto_create', compact('categorias', 'proveedores'));
    }

    /**
     * Registrar nuevo producto
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'unidad' => 'required|string',
            
            'fecha_vencimiento' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_inicial' => 'nullable|numeric|min:0', // Nuevo campo opcional
        ]);

        // Checkbox: si no está marcado, forzar a false
        $validatedData['check'] = $request->has('check') ? 1 : 0;

        // Si no tiene fecha de vencimiento, dejar null
        if (!$validatedData['check']) {
            $validatedData['fecha_vencimiento'] = null;
        }

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $validatedData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        // Manejo del stock inicial (opcional)
        $stock_inicial = $validatedData['stock_inicial'] ?? 0;
        unset($validatedData['stock_inicial']); // No existe en la BD, lo quitamos

        // Asignar stock_actual
        $validatedData['stock_actual'] = $stock_inicial;

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }
    public function show($id)
    {
        $producto = Producto::with(['categoria', 'proveedor'])->findOrFail($id);
        return view('producto_show', compact('producto'));
    }

    /**
     * Editar producto
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('producto_edit', compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Actualizar producto existente
     */
    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'unidad' => 'required|string',
         
            'fecha_vencimiento' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData['check'] = $request->has('check') ? 1 : 0;

        if (!$validatedData['check']) {
            $validatedData['fecha_vencimiento'] = null;
        }

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validatedData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        // ⚠️ No permitir editar stock_actual directamente desde este controlador
        // El stock_actual se modifica solo a través del InventarioController.

        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy(Producto $producto)
    {
        // Evitar eliminar si el producto tiene movimientos de inventario
        if ($producto->inventarios()->exists()) {
            return redirect()->route('productos.index')->withErrors([
                'error' => ' No se puede eliminar este producto porque tiene movimientos de inventario registrados.',
            ]);
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', '🗑️ Producto eliminado correctamente.');
    }
     // Restaurar
    public function restore($id)
    {
        $product = Producto::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->back()->with('success', 'Producto restaurado correctamente.');
    }

    // Eliminar definitivamente uno
    public function forceDelete($id)
    {
        $product = Producto::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->back()->with('success', 'Producto eliminado permanentemente.');
    }

    // Eliminar definitivamente todos los productos eliminados
    public function forceDeleteAll()
    {
        $deletedProducts = Producto::onlyTrashed()->get();

        if ($deletedProducts->isEmpty()) {
            return redirect()->back()->with('error', 'No hay productos eliminados para borrar definitivamente.');
        }

        foreach ($deletedProducts as $product) {
            $product->forceDelete();
        }

        return redirect()->back()->with('success', 'Todos los productos eliminados han sido borrados permanentemente.');
    }

    // Mostrar productos eliminados
    public function deleted()
    {
        $deletedProducts = Producto::onlyTrashed()->paginate(10);
        return view('producto_elim', compact('deletedProducts'));
    }
}
