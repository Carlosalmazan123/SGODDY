<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'facturas'; 
       protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $fillable = [ 'fecha', 'total','user_id'];
  
 protected $casts = [
        'fecha' => 'date', // <-- aquí
    ];
    
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
public function user()
     {
         return $this->belongsTo(User::class);
     }
}
