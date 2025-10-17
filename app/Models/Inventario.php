<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $dates = ['deleted_at'];
    protected $table = 'inventario';

    protected $fillable = ['producto_id', 'stock','tipo_movimiento', 'descripcion', 'fecha_movimiento', 'usuario_id'
, 'stock_anterior', 'stock_nuevo'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}

