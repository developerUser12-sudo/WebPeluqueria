<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BloqueosHorarios;
use Illuminate\Http\Request;

class BloqueosHorariosController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date|before:fecha_fin',
        'fecha_fin' => 'required|date|after:fecha_inicio',
    ]);

    BloqueosHorarios::create([
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
    ]);

    return back();
}
}
