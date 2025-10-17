<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware("can:user.index")->only("index");
        $this->middleware("can:user.create")->only("create","store");
        $this->middleware("can:user.edit")->only("edit","update");
        $this->middleware("can:user.delete")->only("destroy");
    }
    public function validarForm(Request $request){
      
        $messages = [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'password.different' => 'La contraseña no puede ser igual a los tres primeros caracteres del nombre de usuario o del correo electrónico.',
             'email.unique'=>'El correo electronico ya esta en uso.'
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    $name = strtolower($request->input('name'));
                    $email = strtolower($request->input('email'));
                    $password = strtolower($value);

                    for ($i = 0; $i <= strlen($password) - 3; $i++) {
                        $substring = substr($password, $i, 3);
                        if (strpos($name, $substring) !== false || strpos($email, $substring) !== false) {
                            $fail('La contraseña no puede contener tres caracteres consecutivos del nombre de usuario o del correo electrónico.');
                        }
                    }
                },
            ],
        ], $messages);
    }

    public function validarFormUpdate(Request $request, $id){
        $messages = [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'password.different' => 'La contraseña no puede ser igual a los tres primeros caracteres del nombre de usuario o del correo electrónico.',
            'email.unique' => 'El correo electrónico ya está en uso.'
        ];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
    
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    $name = strtolower($request->input('name'));
                    $email = strtolower($request->input('email'));
                    $password = strtolower($value);

                    for ($i = 0; $i <= strlen($password) - 3; $i++) {
                        $substring = substr($password, $i, 3);
                        if (strpos($name, $substring) !== false || strpos($email, $substring) !== false) {
                            $fail('La contraseña no puede contener tres caracteres consecutivos del nombre de usuario o del correo electrónico.');
                        }
                    }
                },
            ],
        ],
        
        $messages);
       
    }

    public function index(Request $request)
    {
        $busqueda=trim($request->get("busqueda"));


        $users=User::where("users.name","LIKE","%".$busqueda."%")
        ->orWhere("users.email","LIKE","%".$busqueda."%")

        ->paginate(7);

        return view("user_index", ["users" => $users, "busqueda" => $busqueda]);
    }
    public function create()
{
    $propietarios = Propietario::all(); // Obtener todos los propietarios
    return view('user_create', compact('propietarios'));
}

    public function store(Request $request){
        $this->validarForm($request);
        User::create($request->all());


        return redirect()->route("users.index")->with(["mensaje"=>"usuario creado"]);
    }
    public function edit(string $id){
        $user=User::find($id);
        return view("user_edit",["user"=>$user]);
    }
    public function update(Request $request, string $id){
        $this->validarFormUpdate($request, $id);
        $user=User::find($id);
        $user->update($request->all());
        $user->update(["actualizacion"=>now()]);
        return redirect()->route("users.index")->with(["mensaje"=>"Usuario actualizado exitosamente"]);
    }
     public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
  
    public function trashed()
    {
        $users = User::onlyTrashed()->paginate(7);
        return view('user_elim', compact('users'));
    }

    // 🔵 Restaurar usuario eliminado
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->back()->with('success', 'Usuario restaurado correctamente.');
    }

    // 🔴 Eliminar permanentemente
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->back()->with('success', 'Usuario eliminado permanentemente.');
    }
    public function forceDeleteAll()
{
    $deletedUsers = User::onlyTrashed()->get();

    if ($deletedUsers->isEmpty()) {
        return redirect()->back()->with('error', 'No hay usuarios eliminados para borrar definitivamente.');
    }

    foreach ($deletedUsers as $user) {
        $user->forceDelete();
    }

    return redirect()->back()->with('success', 'Todos los usuarios eliminados han sido borrados permanentemente.');
}


}
