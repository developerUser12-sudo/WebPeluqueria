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
        $citas = Citas::with('user')->get();
        $usuario=auth()->id();
        return view('reservar', compact('diasBloqueados', 'horasBloqueadas','usuario','citas'));
    }
    public function reservar(Request $request)
    {
        $request->validate([
            'servicio' => 'required',
            'peluquero' => 'required',
            'dia' => 'required',
            'hora' => 'required',
        ]);
        $precio = 0;
        switch ($request->servicio) {
            case 'afeitado_de_cabeza_y_barba':
                $precio = 10;
                break;
            case 'arreglo_de_barba':
                $precio = 6;
                break;
            case 'corte_y_barba':
                $precio = 13;
                break;
            case 'corte_y_barba_ritual':
                $precio = 15;
                break;
            case 'corte_de_pelo':
                $precio = 10;
                break;

        }
        
        $cita = Citas::create([
            'id_usuario' => auth()->id(),
            'servicio' => $request->servicio,
            'peluquero' => $request->peluquero,
            'dia' => $request->dia,
            'hora' => $request->hora,
            'precio' => $precio,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
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
        $citasHoy = Citas::where('dia', Carbon::today())->get();
        $preciosHoy = Citas::where('dia', Carbon::today())->get();
        $totalHoy = $preciosHoy->sum('precio');

        return view('admin.adminpage', compact('citasFuturas', 'citasPasadas', 'citasHoy','totalHoy'));
    }
    public function confirmada($id)
    {
        $cita = Citas::find($id);
        if ($cita->id_usuario !== auth()->id()) {
            return redirect('/');
        }

        return view('citaConfirmada', compact('cita'));
    }
    public function calendar($id)
    {
        $cita = Citas::find($id);

        $inicio = Carbon::parse($cita->dia . ' ' . $cita->hora);
        $fin = $inicio->copy()->addMinutes(30);

        $inicioICS = $inicio->format('Ymd\THis');
        $finICS = $fin->format('Ymd\THis');
        $cita->servicio = str_replace('_', ' ', $cita->servicio);
        $ics = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//LM Barber//Reserva Citas//ES
BEGIN:VEVENT
UID:{$cita->id}@lmbarber
DTSTAMP:" . $inicio->format('Ymd\THis') . "
DTSTART:$inicioICS
DTEND:$finICS
SUMMARY:Cita LM Barber
DESCRIPTION:Cita para {$cita->servicio}
LOCATION:LM Barber
END:VEVENT
END:VCALENDAR";

        return response($ics)->header('Content-Type', 'text/calendar')->header('Content-Disposition', 'attachment; filename=cita.ics');
    }
}
