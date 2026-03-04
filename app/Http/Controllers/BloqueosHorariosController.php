<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\BloqueosHorarios;
use Illuminate\Http\Request;
use function _PHPStan_781aefaf6\React\Promise\all;

class BloqueosHorariosController extends Controller
{
    public function store(Request $request)
    {
        if ($request->tipo == 'dia_entero') {

            $request->validate([
                'tipo' => 'required',
                'dia' => 'required|date',
            ]);

            $inicio = $request->dia . ' 00:00:00';
            $fin = $request->dia . ' 23:59:59';

        } else {

            $request->validate([
                'tipo' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
            ]);

            $inicio = $request->fecha_inicio;
            $fin = $request->fecha_fin;
        }

        BloqueosHorarios::create([
            'tipo' => $request->tipo,
            'fecha_inicio' => $inicio,
            'fecha_fin' => $fin,
        ]);

        return back();
    }

    public function create()
    {
        $horasBloqueadas = BloqueosHorarios::where('tipo', 'franja_horaria')
            ->get(['fecha_inicio', 'fecha_fin']);
        $diasBloqueados = BloqueosHorarios::where('tipo', 'dia_entero')
            ->get()
            ->map(function ($bloqueo) {
                return Carbon::parse($bloqueo->fecha_inicio)->format('Y-m-d');
            });

        return view('reservar', compact('diasBloqueados', 'horasBloqueadas'));
    }
}
