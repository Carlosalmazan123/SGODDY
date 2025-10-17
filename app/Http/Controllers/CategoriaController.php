<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class CategoriaController extends Controller
{
    public function __construct(){
        $this->middleware("can:categoria.index")->only("index");
        $this->middleware("can:categoria.create")->only("create","store");
        $this->middleware("can:categoria.edit")->only("edit","update");
        $this->middleware("can:categoria.delete")->only("destroy");
    }
    public function index()
    {
        // Verificar si el usuario tiene permisos para ver las categorías
        // Retornar la vista con las categorías
        $categorias = Categoria::paginate(6);
        return view('categoria_index', compact('categorias'));
    }

    public function create()
    {
        return view('categoria_create');
    }

    // Almacenar una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito');
    }

public function edit($id)
{
    $categoria = Categoria::findOrFail($id);
    return view('categoria_edit', compact('categoria'));
}

// Guardar cambios
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ]);

    $categoria = Categoria::findOrFail($id);
    $categoria->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
}

    public  function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
    public function deleted(){
        $deletedCategorias = Categoria::onlyTrashed()->paginate(6);
        return view('categoria_elim', compact('deletedCategorias'));
    }
    public function restore($id){
        $categoria = Categoria::onlyTrashed()->findOrFail($id);
        $categoria->restore();
        return redirect()->back()->with('success', 'Categoría restaurada correctamente.');
    }
    public function forceDelete($id){
        $categoria = Categoria::onlyTrashed()->findOrFail($id);
        $categoria->forceDelete();
        return redirect()->back()->with('success', 'Categoría eliminada permanentemente.');
    }
    public function forceDeleteAll(){
        $categorias = Categoria::onlyTrashed()->get();
        foreach($categorias as $categoria){
            $categoria->forceDelete(); 
        }
        return redirect()->back()->with('success', 'Todas las categorías eliminadas permanentemente.');
    }   
}
