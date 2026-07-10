<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminPuntosController extends Controller
{
    public function editarPuntosView($id)
    {
        $usuario = User::find($id);
        return view('admin.editarPuntos', compact('usuario'));
    }
    public function editarPuntos(Request $request, $id)
    {
        $usuario = User::find($id);

        if ($request->filled('puntos')) {
            $usuario->puntos = $request->puntos;
        }

        $usuario->save();

        return redirect('admin')->with('success', 'Puntos editados');
    }
}
