<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Citas;

class NotificacionCitaAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $cita;

    public function __construct(Citas $cita)
    {
        $this->cita = $cita;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Cita confirmada')
            ->view('notificacion-cita-admin');
    }

    /**
     * Get the message content definition.
     */

}
