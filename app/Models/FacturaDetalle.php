<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model {
    protected $fillable = ['factura_id', 'producto_id', 'cantidad', 'subtotal'];

    public function factura() {
        return $this->belongsTo(Factura::class);
    }

    public function producto() {
        return $this->belongsTo(Producto::class);
    }
    public function paciente()
{
    return $this->belongsTo(Paciente::class);
}
}
