<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MovimientosPuntos;
use Illuminate\Http\Request;

class HistorialPuntosController extends Controller
{
    public function show()
    {
        $movimientos = MovimientosPuntos::where('id_usuario', auth()->id())->get();
        return view('historial-puntos', compact('movimientos'));

    }
}
