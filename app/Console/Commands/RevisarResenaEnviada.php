<?php

namespace App\Console\Commands;

use App\Models\Citas;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoResena;

class RevisarResenaEnviada extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revisar-resena-enviada';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $citas = Citas::where('resenia_enviada', false)->where('cancelada',false)->get();
        foreach ($citas as $cita) {
            $fechaHora = Carbon::parse($cita->dia . ' ' . $cita->hora);
            if ($fechaHora->between(now()->subHours(2), now()->subHours(1))) {
                $correo = $cita->user->email ?? $cita->correo;
                if (!$correo) {
                    continue;
                }
                Mail::to($correo)->queue(new CorreoResena($cita));
                $cita->resenia_enviada = true;
                $cita->save();
            }
        }

    }
}
