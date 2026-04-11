<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $queryFuturas = Citas::where('dia', '>=', Carbon::today());

        if ($request->filled('search')) {
            $search = $request->search;

            $queryFuturas->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('telefono', 'like', "%$search%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%");
                    });
            });
        }

        $citasFuturas = $queryFuturas
            ->orderBy('dia')
            ->orderBy('hora')
            ->paginate(6)
            ->withQueryString(); 

        $citasPasadas = Citas::where('dia', '<', Carbon::today())
            ->orderBy('dia', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(6);

        $citasHoy = Citas::where('dia', Carbon::today())->get();
        $preciosHoy = Citas::where('dia', Carbon::today())->get();
        $totalHoy = $preciosHoy->sum('precio');
        $horariosBloqueados = BloqueosHorarios::all();

        return view('admin.adminpage', compact(
            'citasFuturas',
            'citasPasadas',
            'citasHoy',
            'totalHoy',
            'horariosBloqueados'
        ));
    }
}
