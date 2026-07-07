<?php

namespace App\Mail;

use App\Models\ListaEspera;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AvisoCita extends Mailable
{
    use Queueable, SerializesModels;

   public $lista;

    public function __construct(ListaEspera $lista)
    {
        $this->lista = $lista;
    }
    public function build()
    {
        return $this->subject('Hay una cita disponible en LM Barber')
            ->view('emails.aviso-cita');
    }

    /**
     * Get the message envelope.
     */
  
}
