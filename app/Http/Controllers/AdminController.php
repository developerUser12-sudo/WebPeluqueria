<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\CuponValidado;
use App\Mail\Mensaje;
use App\Models\CuponesGenerados;
use App\Models\MovimientosPuntos;
use Illuminate\Http\Request;
use App\Models\BloqueosHorarios;
use App\Models\Citas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use function Illuminate\Support\now;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $queryFuturas = $this->aplicarFiltrosCitas(
            Citas::where(function ($q) {
                $q->whereDate('dia', '>', Carbon::today())
                    ->orWhere(function ($q2) {
                        $q2->whereDate('dia', Carbon::today())
                            ->where('hora', '>=', Carbon::now()->format('H:i'));
                    });
            })->where('cancelada', false),
            $request
        );

        $queryPasadas = $this->aplicarFiltrosCitas(
            Citas::where(function ($q) {
                $q->whereDate('dia', '<', Carbon::today())
                    ->orWhere(function ($q2) {
                        $q2->whereDate('dia', Carbon::today())
                            ->where('hora', '<', Carbon::now()->format('H:i'));
                    });
            })->where('cancelada', false),
            $request
        );
        $queryCalendario = $this->aplicarFiltrosCitas(
            Citas::query()->where('cancelada', false),
            $request
        );
        $citasCalendario = $queryCalendario
            ->with('user')
            ->orderBy('dia')
            ->orderBy('hora')
            ->get();
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

        $citasEstadisticas = $this->aplicarFiltrosEstadisticas(Citas::query()->where('cancelada', false), $request)->get();
        $precioEstadisticas=0;
        foreach ($citasEstadisticas as $cita) {
            $precioEstadisticas+=$cita->precio;
        }
        $horariosBloqueados = BloqueosHorarios::where('fecha_fin', '>', now())->orderBy('fecha_fin', 'asc')->paginate(5, ['*'], 'bloqueos');
        $movimientosPendientes = $this->aplicarFiltrosCupones(
            MovimientosPuntos::with(['user', 'cupon', 'cupongenerado'])
                ->where('motivo', 'canjeo')
                ->where('pendiente', true),
            $request
        )->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'pendientes_page');


        $movimientosValidados = $this->aplicarFiltrosCupones(
            MovimientosPuntos::with(['user', 'cupon', 'cupongenerado'])
                ->where('motivo', 'canjeo')
                ->where('pendiente', false),
            $request
        )->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'validados_page');
        $usuarios = User::paginate(5, ['*'], 'usuarios');
        return view('admin.adminpage', compact(
            'citasFuturas',
            'citasCalendario',
            'citasPasadas',
            'citasEstadisticas',
            'precioEstadisticas',
            'movimientosValidados',
            'movimientosPendientes',
            'horariosBloqueados',
            'usuarios',
        ));
    }

    private function aplicarFiltrosCitas($query, $request)
    {
        return $query
            ->when($request->filled('searchCitas'), function ($q) use ($request) {
                $search = $request->searchCitas;

                $q->where(function ($q2) use ($search) {
                    $q2->where('nombre', 'like', "%$search%")
                        ->orWhere('telefono', 'like', "%$search%")
                        ->orWhereHas('user', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%$search%")
                                ->orWhere('phone', 'like', "%$search%");
                        });
                });
            })
            ->when($request->filled('fechaCitas'), function ($q) use ($request) {
                $q->whereDate('dia', $request->fechaCitas);
            });
    }
    private function aplicarFiltrosCupones($query, $request)
    {
        return $query
            ->when($request->filled('searchCupones'), function ($q) use ($request) {
                $search = $request->searchCupones;

                $q->where(function ($q2) use ($search) {

                    $q2->whereHas('user', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%");
                    })

                        ->orWhereHas('cupon', function ($q4) use ($search) {
                            $q4->where('titulo', 'like', "%$search%");
                        })
                        ->orWhereHas('cupongenerado', function ($q5) use ($search) {
                            $q5->where('cupon', 'like', "%$search%");
                        });
                });
            })
            ->when($request->filled('fechaCupones'), function ($q) use ($request) {
                $q->whereDate('created_at', $request->fechaCupones);
            });
    }
    private function aplicarFiltrosEstadisticas($query, $request)
    {
        return $query
            ->when($request->filled('diaInicio'), function ($q) use ($request) {
                $q->whereBetween('dia', [$request->diaInicio, $request->diaFin]);
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
        Mail::to($usuario->email)->queue(new CuponValidado($movimiento));
        return redirect()->back()->with('success', 'Cupón validado');
    }
    public function mandarMensaje(Request $request)
    {
        $request->validate([
            'cuerpo' => 'required|string'
        ]);
        $mensaje = $request->cuerpo;
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            Mail::to($usuario->email)
                ->queue(new Mensaje($mensaje));

        }
        $correos = Citas::whereNotNull('correo')->distinct()->pluck('correo');
        foreach ($correos as $correo) {
            Mail::to($correo)->queue(new Mensaje($mensaje));
        }
        return redirect()->back()->with('success', 'Mensaje enviado');

    }
}
