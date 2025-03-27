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
        
        Permission::create([   
            "name"=>"user.index"
        ]);
        Permission::create([
            "name"=>"user.create"
        ]);
        Permission::create([
            "name"=>"user.edit"
        ]);
        Permission::create([
            "name"=>"user.delete"
        ]);
        Permission::create([
            "name"=>"permission.index"
        ]);
        Permission::create([
            "name"=>"permission.create"
        ]);
        Permission::create([
            "name"=>"permission.edit"
        ]);
        Permission::create([
            "name"=>"permission.delete"
        ]);
        Permission::create([
            "name"=>"role.index"
        ]);
        Permission::create([
            "name"=>"role.create"
        ]);
        Permission::create([
            "name"=>"role.edit"
        ]);
        Permission::create([
            "name"=>"role.delete"
        ]);
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
        "role.index","role.create","role.edit", "role.delete"]);
        $userAdmin->syncRoles(["admin"]);
    }
}
