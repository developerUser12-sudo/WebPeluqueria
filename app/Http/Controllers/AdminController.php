<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CuponesGenerados;
use App\Models\MovimientosPuntos;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $queryFuturas = $this->aplicarFiltros(
            Citas::where(function ($q) {
                $q->whereDate('dia', '>', Carbon::today())
                    ->orWhere(function ($q2) {
                        $q2->whereDate('dia', Carbon::today())
                            ->where('hora', '>=', Carbon::now()->format('H:i'));
                    });
            }),
            $request
        );

        $queryPasadas = $this->aplicarFiltros(
            Citas::where(function ($q) {
                $q->whereDate('dia', '<', Carbon::today())
                    ->orWhere(function ($q2) {
                        $q2->whereDate('dia', Carbon::today())
                            ->where('hora', '<', Carbon::now()->format('H:i'));
                    });
            }),
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
        $movimientos = MovimientosPuntos::orderBy('created_at', 'desc')->get();
        $cuponesGenerados = CuponesGenerados::get();
        return view('admin.adminpage', compact(
            'citasFuturas',
            'citasPasadas',
            'citasHoy',
            'totalHoy',
            'movimientos',
            'horariosBloqueados',
            'cuponesGenerados',
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
    public function validarCupon($id)
    {
        $cuponGenerado = CuponesGenerados::create([
            'cupon' => 'LM-' . Str::random(4),

        ]);
        $movimiento = MovimientosPuntos::find($id);
        $movimiento->update([
            'pendiente' => false,
            'id_cupongenerado' => $cuponGenerado->id,
        ]);

        $movimiento->save();
        $usuario = User::find($movimiento->id_usuario);
        $usuario->puntos -= $movimiento->puntos;
        $usuario->save();

        return redirect()->back()->with('success', 'Cupón validado');
    }
}
