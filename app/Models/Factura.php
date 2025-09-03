<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'facturas'; 
       protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $fillable = ['paciente_id', 'fecha', 'total'];
  

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
   public function producto()
{
    return $this->belongsTo(Producto::class);
}
    public function detalles()
    {
        return $this->hasMany(FacturaDetalle::class);
    }
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

}
