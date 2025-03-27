<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("can:user.edit")->only("edit","update");
    }
    public function edit($id){
        $user=User::find($id);
        $roles=Role::all();
        return view("user_role_edit", ["user"=>$user,"roles"=>$roles]);
    }
    public function update( Request $request, $id ){
        
        $user=User::find($id);
        $user->syncRoles($request["roles"]);
        return redirect()->route("users.index");
    }
}
