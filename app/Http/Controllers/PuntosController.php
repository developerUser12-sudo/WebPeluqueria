<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MovimientosPuntos;
use App\Models\Cupones;
use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\User;

class PuntosController extends Controller
{
    public function show()
    {
        $user = User::find(auth()->id());
        $vales = Cupones::get();

        return view('mis-puntos', compact('user', 'vales'));
    }
    public function servicioCompletado($id)
    {
        $cita = Citas::find($id);
        $cita->completado = true;
        $cita->save();
        $usuario = User::find($cita->id_usuario);
        $puntos = 0;
        switch ($cita->servicio) {
            case 'corte_de_pelo':
                $puntos = 10;
                break;
            case 'corte_y_barba_ritual':
                $puntos = 15;
                break;
            case 'afeitado_de_cabeza_y_barba':
                $puntos = 10;
                break;
            case 'arreglo_de_barba':
                $puntos = 5;
                break;
            case 'afeitado_de_cabeza_o_numero':
                $puntos = 5;
                break;

        }
        $usuario->puntos += $puntos;
        $usuario->save();
        MovimientosPuntos::create([
            'id_usuario' => $usuario->id,
            'motivo' => 'reserva',
            'puntos' => $puntos,

        ]);


        return redirect('admin')->with('success', 'Confirmación de cita realizada.');
    }
    public function canjear($id)
    {
        $vale = Cupones::find($id);
        if (MovimientosPuntos::where('id_usuario', auth()->id())->where('pendiente',true)->exists()) {
            return redirect()->back()->with('error', 'Ya tienes un cupón pendiente de revisión');
            
        }
        MovimientosPuntos::create([
            'id_usuario' => auth()->id(),
            'id_cupon' => $vale->id,
            'motivo' => 'canjeo',
            'puntos' => $vale->puntos,
            'pendiente' => true
        ]);

        return redirect()->back()->with('success', 'Cupón pendiente de revisión');
    }

}
