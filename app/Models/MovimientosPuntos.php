<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosPuntos extends Model
{
    protected $table = 'movimientospuntos';
     protected $fillable = [
        'id_usuario',
        'motivo',
        'puntos',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }
}
