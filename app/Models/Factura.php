<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'facturas'; 
    protected $fillable = [
        'paciente_id',
        'total',
        'metodo_pago',
        'estado',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
