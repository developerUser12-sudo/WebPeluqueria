<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueosHorarios extends Model
{
    protected $table = 'bloqueoshorarios';
     protected $fillable = [
        'tipo',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];
}
