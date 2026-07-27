<?php

namespace App\Mail;

use App\Models\Citas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorreoResena extends Mailable
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
        return $this->subject('Cuéntanos que te ha parecido tu experiencia')
            ->view('emails.resena');
    }
}
