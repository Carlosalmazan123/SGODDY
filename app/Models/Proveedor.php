<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $dates = ['deleted_at'];
    protected $table = 'proveedors';
    protected $fillable = ['nombre', 'contacto', 'telefono', 'email', 'direccion'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}

