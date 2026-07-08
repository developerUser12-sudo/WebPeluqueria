<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Citas;
use Carbon\Carbon;
class ListaEsperaController extends Controller
{
    public function show(Request $request)
    {
        $usuarios = User::get();
        $dia = $request->dia;
        $profesional = $request->peluquero;

        if ($this->comprobarDia($dia, $profesional)) {
            return view('lista-espera', compact('dia', 'profesional', 'usuarios'));
        } else {
            return redirect()->back();
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'inicio' => 'required',
            'fin' => 'required',
        ]);

        ListaEspera::create([
            'id_usuario' => auth()->id(),
            'profesional' => $request->peluquero,
            'hora_inicio' => $request->inicio,
            'hora_fin' => $request->fin,
            'dia' => $request->dia,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'correo' => $request->email,
            'avisado' => false,

        ]);
        return redirect('/')->with('success', 'Apuntado a la lista de espera');

    }
    public function comprobarDia($dia, $profesional)
    {

        $fecha = Carbon::parse($dia);
        $horas = [];
        if ($fecha->isSaturday()) {
            $horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30'];

        } else if ($fecha->isMonday()) {
            $horas = ['17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00'];

        } else {
            $horas = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00'];

        }

        foreach ($horas as $hora) {
            $horaCarbon = Carbon::createFromFormat('H:i', $hora);
            if (now()->greaterThan($horaCarbon)&&$fecha->isToday()) {
                continue;
            }
            if (!Citas::where('dia', $dia)->where('cancelada', false)->where('peluquero', $profesional)->where('hora', $hora)->exists()) {
                return false;
            }
        }
        return true;
    }
}
