<?php

namespace App\Http\Controllers;
use App\Mail\CancelarCita;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
use App\Models\User;
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
        $citas = Citas::with('user')
            ->where('cancelada', false)
            ->where('dia', '>=', now()->toDateString())
            ->where('dia', '<=', now()->addDays(30)->toDateString())
            ->get()
            ->filter(function ($cita) {

                $fechaCita = Carbon::parse(
                    $cita->dia . ' ' . $cita->hora
                );

                return $fechaCita->greaterThan(
                    now()->addMinutes(5)
                );
            })
            ->groupBy('peluquero');
        $usuario = auth()->id();
        $telefonos=User::get();
        return view('reservar', compact('diasBloqueados', 'horasBloqueadas', 'usuario', 'citas','telefonos'));
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
                $precio = 14;
                break;
            case 'arreglo_de_barba':
                $precio = 7;
                break;
            case 'afeitado_de_cabeza_o_numero':
                $precio = 8;
                break;
            case 'corte_y_barba_ritual':
                $precio = 16;
                break;
            case 'corte_de_pelo':
                $precio = 11;
                break;

        }
        $token = "";
        if (auth()->guest()) {
            $token = Str::random(40);
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
            'completado' => false,
            'cancelada' => false,
            'recordatorio_enviado' => false,
            'resenia_enviada' => false,
        ]);
        if (auth()->check()) {
            Mail::to(auth()->user()->email)->queue(new CitaReservada($cita));
        } else {
            if ($request->email != null) {

                Mail::to($request->email)->queue(new CancelarCita($cita));
            }
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
