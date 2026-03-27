<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;

class CitasController extends Controller
{
    public function editarCitaView($id)
    {
        $cita = Citas::find($id);
        return view('admin.editarCita', compact('cita'));
    }
    public function editarCita(Request $request, $id)
    {
        $cita = Citas::find($id);

        if ($request->filled('servicio')) {
            $cita->servicio = $request->servicio;
        }

        if ($request->filled('peluquero')) {
            $cita->peluquero = $request->peluquero;
        }

        if ($request->filled('dia')) {
            $cita->dia = $request->dia;
        }

        if ($request->filled('hora')) {
            $cita->hora = $request->hora;
        }


        $cita->save();

        return redirect('admin')->with('success', 'Cita editada');
    }
    public function eliminarCita($id)
    {
        $cita = Citas::find($id);
        $cita->delete();
        return back()->with('success', 'Cita eliminada');
    }

}
