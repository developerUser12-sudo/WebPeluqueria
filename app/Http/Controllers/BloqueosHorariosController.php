<?php

namespace App\Http\Controllers;


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

        return back()->with('success', 'Horario bloqueado agregado');
    }
    public function eliminarHorario($id)
    {
        $horario = BloqueosHorarios::find($id);
        $horario->delete();
        return back()->with('success', 'Horario bloqueado eliminado');
    }
    

    
}
