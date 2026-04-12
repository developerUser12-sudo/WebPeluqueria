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
        $queryFuturas = $this->aplicarFiltros(
            Citas::where('dia', '>=', Carbon::today()),
            $request
        );

        $queryPasadas = $this->aplicarFiltros(
            Citas::where('dia', '<', Carbon::today()),
            $request
        );

        $citasFuturas = $queryFuturas
            ->orderBy('dia')
            ->orderBy('hora')
            ->paginate(5, ['*'], 'futuras_page')
            ->withQueryString();

        $citasPasadas = $queryPasadas
            ->orderBy('dia', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(5, ['*'], 'pasadas_page')
            ->withQueryString();
            
        $citasHoyQuery = Citas::whereDate('dia', Carbon::today());

        $citasHoy = $citasHoyQuery->count();
        $totalHoy = $citasHoyQuery->sum('precio');

        $horariosBloqueados = BloqueosHorarios::all();

        return view('admin.adminpage', compact(
            'citasFuturas',
            'citasPasadas',
            'citasHoy',
            'totalHoy',
            'horariosBloqueados'
        ));
    }

    private function aplicarFiltros($query, $request)
    {
        return $query
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($q2) use ($search) {
                    $q2->where('nombre', 'like', "%$search%")
                        ->orWhere('telefono', 'like', "%$search%")
                        ->orWhereHas('user', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%$search%")
                                ->orWhere('phone', 'like', "%$search%");
                        });
                });
            })
            ->when($request->filled('fecha'), function ($q) use ($request) {
                $q->whereDate('dia', $request->fecha);
            });
    }
}
