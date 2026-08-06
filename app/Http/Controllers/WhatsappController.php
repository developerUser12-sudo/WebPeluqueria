<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MensajesRecibidos;
use Illuminate\Http\Request;
use Twilio\TwiML\MessagingResponse;

class WhatsappController extends Controller
{
    public function recibir(Request $request)
    {
        $twiml = new MessagingResponse();
        $twiml->message(
            "👋 Hola.\n\n" .
            "Si desea reservar una cita, hagalo a través de nuestra página lmbarber.es.\n\n" .
            "Por favor, no escriba a este número. Si desea contactar con nosotros, escriba al siguiente número: +34623199913"
        );
        return response($twiml, 200)
            ->header('Content-Type', 'text/xml');
    }
}
