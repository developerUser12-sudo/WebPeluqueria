<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    protected $table = 'listaespera';
    protected $fillable = [
        'id_usuario',
        'profesional',
        'hora_inicio',
        'hora_fin',
        'dia',
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'avisado',
       
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario'); 
    }
    protected function hora(): Attribute
    { {
        }

        return Attribute::make(

            get: fn($value) => substr($value, 0, 5), 

        ); {
        }
    }
}
