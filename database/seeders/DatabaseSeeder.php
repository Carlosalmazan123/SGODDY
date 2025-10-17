<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Propietario;
use App\Models\Proveedor;
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
        $propietario=Propietario::create([
            "nombre"=>"Josue Carlos",
            "apellido"=>"Almazán Paredes",
            "telefono"=>"72431122",
            "direccion"=>"admin",
            "correo"=>"josuealmazam142@gmail.com",
            "ci"=>"10626599",
            "opt_in_whatsapp"=>true,
         ]);
         /**
         * Categorías
         */
        $categoria1 = Categoria::create([
            "nombre" => "Medicamentos",
            "descripcion" => "Fármacos veterinarios para diversas especies."
        ]);

        $categoria2 = Categoria::create([
            "nombre" => "Accesorios",
            "descripcion" => "Collares, correas, juguetes y artículos para mascotas."
        ]);

        $categoria3 = Categoria::create([
            "nombre" => "Alimentos",
            "descripcion" => "Piensos, croquetas y suplementos nutricionales."
        ]);

        $categoria4 = Categoria::create([
            "nombre" => "Higiene",
            "descripcion" => "Shampoo, cepillos, cortaúñas y artículos de aseo."
        ]);

        /**
         * Proveedores
         */
        $proveedor1 = Proveedor::create([
            "nombre" => "VetPharma Bolivia",
            "contacto" => "Lic. Ramírez",
            "telefono" => "76543210",
            "email" => "contacto@vetpharma.bo",
            "direccion" => "Av. Busch #456, La Paz"
        ]);

        $proveedor2 = Proveedor::create([
            "nombre" => "Mascotas & Salud",
            "contacto" => "Ing. Fernández",
            "telefono" => "78965412",
            "email" => "ventas@mascotasalud.com",
            "direccion" => "Calle Comercio #123, Cochabamba"
        ]);

        $proveedor3 = Proveedor::create([
            "nombre" => "PetWorld Importaciones",
            "contacto" => "Srta. Gutiérrez",
            "telefono" => "70112233",
            "email" => "info@petworld.com",
            "direccion" => "Av. América #321, Santa Cruz"
        ]);

        /**
         * Productos
         */
        Producto::create([
            "nombre" => "Vacuna Rabia",
            "categoria_id" => $categoria1->id,
            "precio" => 50.00,
            "unidad" => "dosis",
            "fecha_vencimiento" => "2026-12-31",
            "check" => true,
            "proveedor_id" => $proveedor1->id,
            "imagen" => null
        ]);

        Producto::create([
            "nombre" => "Antiparasitario Interno",
            "categoria_id" => $categoria1->id,
            "precio_compra" => 20.00,
            "precio" => 35.00,
            "unidad" => "tableta",
            "fecha_vencimiento" => "2025-08-20",
            "check" => true,
            "proveedor_id" => $proveedor1->id,
            "imagen" => null
        ]);

        Producto::create([
            "nombre" => "Collar Antipulgas",
            "categoria_id" => $categoria2->id,
            "precio_compra" => 50.00,
            "precio" => 80.00,
            "unidad" => "unidad",
            "check" => false,
            "proveedor_id" => $proveedor2->id,
            "imagen" => null
        ]);

        Producto::create([
            "nombre" => "Croquetas Premium Perro Adulto",
            "categoria_id" => $categoria3->id,
            "precio_compra" => 150.00,
            "precio" => 230.00,
            "unidad" => "kilo",
            "fecha_vencimiento" => "2025-06-01",
            "check" => true,
            "proveedor_id" => $proveedor3->id,
            "imagen" => null
        ]);

        Producto::create([
            "nombre" => "Shampoo Antipulgas",
            "categoria_id" => $categoria4->id,
            "precio_compra" => 40.00,
            "precio" => 60.00,
            "unidad" => "litro",
            "check" => false,
            "proveedor_id" => $proveedor2->id,
            "imagen" => null
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
