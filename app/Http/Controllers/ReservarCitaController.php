<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
class ReservarCitaController extends Controller
{
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
    public function reservar(Request $request)
    {
        $request->validate([
            'servicio' => 'required',
            'peluquero' => 'required',
            'dia' => 'required',
            'hora' => 'required',
        ]);
        $cita = Citas::create([
            'id_usuario' => auth()->id(),
            'servicio' => $request->servicio,
            'peluquero' => $request->peluquero,
            'dia' => $request->dia,
            'hora' => $request->hora,
        ]);
        return redirect()->route('cita-confirmada', $cita->id);
    }
    public function show()
    {
        $citasFuturas = Citas::where('dia', '>=', Carbon::today())
            ->orderBy('dia')
            ->orderBy('hora')
            ->paginate(10);

        $citasPasadas = Citas::where('dia', '<', Carbon::today())
            ->orderBy('dia', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(10);

        return view('admin.adminpage', compact('citasFuturas', 'citasPasadas'));
    }
    public function confirmada($id)
    {
        $cita = Citas::find($id);
        if ($cita->id_usuario !== auth()->id()) {
            return redirect('/');
        }

        return view('citaConfirmada', compact('cita'));
    }
}
