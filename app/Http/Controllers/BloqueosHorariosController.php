<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\BloqueosHorarios;
use Illuminate\Http\Request;
use function _PHPStan_781aefaf6\React\Promise\all;
use Carbon\Carbon;

class BloqueosHorariosController extends Controller
{
    public function bloquearHorario(Request $request)
    {
        if ($request->tipo == 'dia_entero') {

            $request->validate([
                'tipo' => 'required',
                'dia' => 'required|date',
            ]);

            $inicio = $request->dia . ' 00:00:00';
            $fin = $request->dia . ' 23:59:59';
            BloqueosHorarios::create([
                'tipo' => $request->tipo,
                'profesional' => $request->profesional,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
            ]);

        } else if ($request->tipo == 'rango_de_dias') {
            $request->validate([
                'dia_inicio' => 'required|date',
                'dia_fin' => 'required|date',
                'tipo' => 'required',
            ]);
            $diaInicio = Carbon::parse($request->dia_inicio);
            $diaFin = Carbon::parse($request->dia_fin);
            do {
                BloqueosHorarios::create([
                    'tipo' => $request->tipo,
                    'profesional' => $request->profesional,
                    'fecha_inicio' => $diaInicio->copy()->startOfDay(),
                    'fecha_fin' => $diaInicio->copy()->endOfDay(),
                ]);
                $diaInicio->addDay();
            } while ($diaInicio->lte($diaFin));
        } else {

            $request->validate([
                'tipo' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
            ]);

            $inicio = $request->fecha_inicio;
            $fin = $request->fecha_fin;
            BloqueosHorarios::create([
                'tipo' => $request->tipo,
                'profesional' => $request->profesional,
                'fecha_inicio' => $inicio,
                'fecha_fin' => $fin,
            ]);
        }
        return back()->with('success', 'Horario bloqueado agregado');
    }
   
    public function eliminarHorario($id)
    {
        $horario = BloqueosHorarios::find($id);
        $horario->delete();
        return back()->with('success', 'Horario bloqueado eliminado');
    }



}
