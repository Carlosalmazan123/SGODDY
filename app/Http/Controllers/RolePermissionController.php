<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("can:role.edit")->only("edit","update");
    }
    public function edit($id){
        $role=Role::find($id);
        $permissions = Permission::all();
        return view("role_permission_edit", ["role"=>$role,"permissions"=>$permissions]);
    }
    public function update(Request $request, $id){
        $role=Role::find($id);
        $role->syncPermissions($request["permissions"]);
        return redirect()->route("roles.index");
    }
}
