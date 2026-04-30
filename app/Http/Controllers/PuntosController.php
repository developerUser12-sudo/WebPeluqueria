<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\User;

class PuntosController extends Controller
{
    public function show()
    {
        $user=User::find(auth()->id());

        return view('mis-puntos',compact('user'));
    }
    public function servicioCompletado($id)
    {
        $cita = Citas::find($id);
        $cita->completado=true;
        $cita->save();
        $usuario = User::find($cita->id_usuario);
        $puntos=0;
        switch ($cita->servicio) {
            case 'corte_de_pelo':
                $puntos=10;
                break;
            case 'corte_y_barba':
                $puntos=12;
                break;
            case 'corte_y_barba_ritual':
                $puntos=15;
                break;
            case 'afeitado_de_cabeza_y_barba':
                $puntos=13;
                break;
            case 'arreglo_de_barba':
                $puntos=6;
                break;
            case 'afeitado_de_cabeza_o_numero':
                $puntos=7;
                break;
            
        }
        $usuario->puntos=$puntos;
        $usuario->save();

        
        return redirect('admin')->with('success', 'Confirmación de cita realizada.');
    }
}
