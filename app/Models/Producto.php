<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'categoria_id', 'precio', 
        'fecha_vencimiento', 'proveedor_id', 'imagen'
    ];

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
