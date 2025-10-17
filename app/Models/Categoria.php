<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory;
    // Definir los campos que se pueden asignar masivamente
    use SoftDeletes;
    protected $fillable = ['nombre', 'descripcion'];
    protected $dates = ['deleted_at'];
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
