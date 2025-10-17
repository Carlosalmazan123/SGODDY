<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturaDetalle extends Model {
    use HasFactory;
    
    protected $fillable = ['factura_id', 'producto_id', 'cantidad', 'subtotal', 'precio'
    ,'servicio_id'];
    
    public function factura() {
        return $this->belongsTo(Factura::class);
    }

    public function producto() {
        return $this->belongsTo(Producto::class);
    }
   public function servicio() {
        return $this->belongsTo(Servicio::class);
    }
}
