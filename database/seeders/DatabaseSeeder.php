<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $userAdmin=User::create([
            "name"=>"admin",
            "email"=>"admin@admin.com",
            "password"=>bcrypt("1234"),
            
        ]);
        
        Permission::create(["name"=>"user.index" ]);
        Permission::create(["name"=>"user.create" ]);
        Permission::create(["name"=>"user.edit"]);
        Permission::create([ "name"=>"user.delete"]);
        Permission::create(["name"=>"permission.index"]);
        Permission::create([ "name"=>"permission.create"]);
        Permission::create(["name"=>"permission.edit" ]);
        Permission::create(["name"=>"permission.delete"]);
        Permission::create(["name"=>"role.index"]);
        Permission::create(["name"=>"role.create"]);
        Permission::create(["name"=>"role.edit"]);
        Permission::create(["name"=>"role.delete"]);
        Permission::create(["name"=>"categoria.index" ]);
        Permission::create(["name"=>"categoria.create" ]);
        Permission::create(["name"=>"categoria.edit"]);
        Permission::create([ "name"=>"categoria.delete"]);
        Permission::create(["name"=>"cita.index" ]);
        Permission::create(["name"=>"cita.create" ]);
        Permission::create(["name"=>"cita.edit"]);
        Permission::create([ "name"=>"cita.delete"]);
        Permission::create(["name"=>"factura.index" ]);
        Permission::create(["name"=>"factura.create" ]);
        Permission::create(["name"=>"factura.edit"]);
        Permission::create([ "name"=>"factura.delete"]);
        Permission::create(["name"=>"historial.show" ]);
        Permission::create(["name"=>"historial.create" ]);
        Permission::create(["name"=>"historial.edit"]);
        Permission::create([ "name"=>"historial.delete"]);
        Permission::create(["name"=>"inventario.index" ]);
        Permission::create(["name"=>"inventario.create" ]);
        Permission::create(["name"=>"inventario.edit"]);
        Permission::create([ "name"=>"inventario.delete"]);
        Permission::create(["name"=>"paciente.index" ]);
        Permission::create(["name"=>"paciente.create" ]);
        Permission::create(["name"=>"paciente.edit"]);
        Permission::create([ "name"=>"paciente.delete"]);
        Permission::create(["name"=>"producto.index" ]);
        Permission::create(["name"=>"producto.create" ]);
        Permission::create(["name"=>"producto.edit"]);
        Permission::create([ "name"=>"producto.delete"]);
        Permission::create(["name"=>"producto.show" ]);
        Permission::create(["name"=>"propietario.index" ]);
        Permission::create(["name"=>"propietario.create" ]);
        Permission::create(["name"=>"propietario.edit"]);
        Permission::create([ "name"=>"propietario.delete"]);
        Permission::create(["name"=>"proveedor.index" ]);
        Permission::create(["name"=>"proveedor.create" ]);
        Permission::create(["name"=>"proveedor.edit"]);
        Permission::create([ "name"=>"proveedor.delete"]);
        Permission::create(["name"=>"servicio.index" ]);
        Permission::create(["name"=>"servicio.create" ]);
        Permission::create(["name"=>"servicio.edit"]);
        Permission::create([ "name"=>"servicio.delete"]);
        Permission::create(["name"=>"ticket.inicio" ]);
        
        $roleAdmin=Role::create([
            "name"=>"admin"
        ]);
        $roleCaja=Role::create([
            "name"=>"cliente"
        ]);
        $role=Role::create([
            "name"=>"vendedor"
        ]);
        $roleAdmin->syncPermissions(["user.index","user.create","user.edit","user.delete","permission.index","permission.create","permission.edit", "permission.delete",
        "role.index","role.create","role.edit", "role.delete","categoria.index","categoria.create","categoria.edit","categoria.delete",
    "cita.index","cita.create","cita.edit","cita.delete","factura.index","factura.create","factura.edit","factura.delete",
    "historial.show","historial.create","historial.edit","historial.delete","inventario.index","inventario.create","inventario.edit","inventario.delete",
    "paciente.index","paciente.create","paciente.edit","paciente.delete","producto.index","producto.create","producto.edit","producto.delete",
    "producto.show","propietario.index","propietario.create","propietario.edit","propietario.delete","proveedor.index","proveedor.create",
    "proveedor.edit","proveedor.delete","servicio.index","servicio.create","servicio.edit","servicio.delete",
    "ticket.inicio"]);
        $userAdmin->syncRoles(["admin"]);
    }
}
