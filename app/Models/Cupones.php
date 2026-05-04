<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{
    protected $fillable = [
        'puntos',
        'titulo',
        'tipo',
    ];
}
