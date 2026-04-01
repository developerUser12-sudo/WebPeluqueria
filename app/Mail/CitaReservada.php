<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Citas;

class CitaReservada extends Mailable
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

    public function build()
    {
        return $this->subject('Cita confirmada')
            ->view('emails.cita-reservada');
    }
}
