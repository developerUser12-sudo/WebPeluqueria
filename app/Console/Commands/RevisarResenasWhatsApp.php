<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use App\Models\Citas;

class RevisarResenasWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:resenas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $wa)
    {
        $citas = Citas::where('cancelada', false)
            ->where('resenia_enviada', false)
            ->get()
            ->filter(function ($cita) {

                $fechaCita = \Carbon\Carbon::parse($cita->dia . ' ' . $cita->hora);

                 return $fechaCita->isPast();
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
                env('TWILIO_TEMPLATE_REVIEW'),
                [
                    "1" => $nombre,

                ]
            );

            $cita->update([
                'resenia_enviada' => true
            ]);
        }
    }
}
