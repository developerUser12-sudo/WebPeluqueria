<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use App\Models\User;

class ListaEsperaController extends Controller
{
    public function show(Request $request)
    {
        $usuarios = User::get();
        $dia = $request->dia;
        $profesional = $request->peluquero;
        return view('lista-espera', compact('dia', 'profesional','usuarios'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'inicio' => 'required',
            'fin' => 'required',
        ]);
      
         ListaEspera::create([
            'id_usuario' => auth()->id(),
            'profesional' => $request->peluquero,
            'hora_inicio' => $request->inicio,
            'hora_fin' => $request->fin,
            'dia' => $request->dia,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'correo' => $request->email,
            'avisado' => false,
           
        ]);
        return redirect('/')->with('success', 'Apuntado a la lista de espera');
        
    }
}
