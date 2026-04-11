<?php

namespace App\Http\Controllers;
use App\Mail\CancelarCita;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
use Illuminate\Support\Facades\Mail;
use App\Mail\CitaReservada;
use Illuminate\Support\Str;
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
        $usuario = auth()->id();
        return view('reservar', compact('diasBloqueados', 'horasBloqueadas', 'usuario', 'citas'));
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
        $token="";
        if (auth()->guest()) {
            $token=Str::random(40);
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
            'token' => $token,
        ]);
        if (auth()->check()) {
            Mail::to(auth()->user()->email)->send(new CitaReservada($cita));
        } else {
            Mail::to($request->email)->send(new CancelarCita($cita));
        }

        return redirect()->route('cita-confirmada', $cita->id);
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
