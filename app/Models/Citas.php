<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $table = 'citas';
    protected $fillable = [
        'id_usuario',
        'servicio',
        'peluquero',
        'dia',
        'hora',
        'precio',
        'nombre',
        'apellido',
        'telefono',
        'token',
        'completado',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }


}
