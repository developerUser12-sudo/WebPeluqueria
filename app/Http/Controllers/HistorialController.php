<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citas;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
{
    public function show()
    {
        $citas = Citas::where('id_usuario', auth()->id())
            ->orderBy('dia', 'desc')
            ->paginate(5);
        return view('historial', compact('citas'));
    }
    public function eliminarCita($id)
    {
        $cita = Citas::find($id);
        $cita->delete();
        return redirect()->back();
    }
}
