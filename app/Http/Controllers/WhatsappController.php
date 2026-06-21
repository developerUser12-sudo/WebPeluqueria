<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MensajesRecibidos;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function recibir(Request $request){
        $from=$request->input('From');
        $body=$request->input('Body');
        MensajesRecibidos::create([
            'mensaje'=>$body,
            'numero'=>$from,
        ]);
        return response('OK', 200);
    }
}
