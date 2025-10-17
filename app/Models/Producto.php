<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nombre',  'categoria_id', 'precio', 'precio_compra',
        'unidad', 'proveedor_id','fecha_vencimiento', 'check', 'imagen', 'stock_actual'
    ];
protected $dates = ['deleted_at'];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function inventarios()
    {
        return $this->hasOne(Inventario::class);
    }
    public function facturas()
{
    return $this->hasMany(Factura::class);
}
// Stock dinámico
    public function getStockAttribute()
    {
        $entradas = $this->inventarios()->where('tipo_movimiento', 'entrada')->sum('stock');
        $salidas  = $this->inventarios()->where('tipo_movimiento', 'salida')->sum('stock');
        return $entradas - $salidas;
    }
}
