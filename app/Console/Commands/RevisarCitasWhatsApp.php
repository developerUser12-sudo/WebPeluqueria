<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use App\Models\Citas;

class RevisarCitasWhatsApp extends Command
{
    protected $signature = 'whatsapp:recordatorios';
    protected $description = 'Envía recordatorios de citas por WhatsApp';

    public function handle(WhatsAppService $wa)
    {
        $citas = Citas::where('cancelada', false)
            ->where('recordatorio_enviado', false)
            ->get()
            ->filter(function ($cita) {

                $fechaCita = \Carbon\Carbon::parse($cita->dia . ' ' . $cita->hora);

                return $fechaCita->between(
                    now()->addMinutes(120),
                    now()->addMinutes(150)
                );
                
            });
        $telefono = '';
        $nombre = '';

        foreach ($citas as $cita) {
            if ($cita->id_usuario == null) {
                $telefono = $cita->telefono;
                $nombre = $cita->nombre;
            } else {
                $telefono = $cita->user->phone;
                $nombre = $cita->user->name;


            }
            $wa->sendTemplate(
                $telefono,
                config('services.twilio.template_reminder'),
                [
                    "1" => $nombre,
                    "2" => \Carbon\Carbon::parse($cita->hora)->format('H:i'),
                ]
            );

            $cita->update([
                'recordatorio_enviado' => true
            ]);
        }
    }
}
