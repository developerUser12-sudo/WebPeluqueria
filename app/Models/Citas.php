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
        'correo',
        'token',
        'completado',
        'cancelada',
        'recordatorio_enviado',
        'resenia_enviada',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }


}
