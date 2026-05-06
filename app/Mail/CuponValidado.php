<?php

namespace App\Mail;

use App\Models\CuponesGenerados;
use App\Models\MovimientosPuntos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CuponValidado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
     public $movimiento;

    public function __construct(MovimientosPuntos $movimiento)
    {
        $this->movimiento = $movimiento;
    }

    public function build()
    {
        return $this->subject('Tu cupón ha sido validado')
            ->view('emails.cupon-validado');
    }
}
