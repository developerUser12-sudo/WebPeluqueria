<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosPuntos extends Model
{
    protected $table = 'movimientospuntos';
     protected $fillable = [
        'id_usuario',
        'id_cupon',
        'id_cupongenerado',
        'motivo',
        'puntos',
        'pendiente',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }
    public function cupon()
    {
        return $this->belongsTo(Cupones::class, 'id_cupon'); 
    }
    public function cupongenerado()
    {
        return $this->belongsTo(CuponesGenerados::class, 'id_cupongenerado');
    }
}
