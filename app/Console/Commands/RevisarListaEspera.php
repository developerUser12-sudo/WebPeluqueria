<?php

namespace App\Console\Commands;

use App\Models\Citas;
use App\Models\ListaEspera;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvisoCita;

class RevisarListaEspera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revisar-lista-espera';

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
        $listas = ListaEspera::where('avisado', false)->get();
        $citas = Citas::where('cancelada', true)->get();
        foreach ($citas as $cita) {
            foreach ($listas as $lista) {
                if ($cita->dia == $lista->dia && $cita->peluquero == $lista->profesional) {
                    $hora = Carbon::createFromFormat('H:i', $cita->hora);
                    $inicio = Carbon::parse($lista->hora_inicio);
                    $fin = Carbon::parse($lista->hora_fin);
                    if ($hora->between($inicio,$fin)) {
                        $correo = $lista->correo ?? $lista->user->email;
                        $lista->avisado = true;
                        $lista->save();
                        Mail::to($correo)->queue(new AvisoCita($lista));

                    }
                }

            }
        }
    }
}
