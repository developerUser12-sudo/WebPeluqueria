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
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
