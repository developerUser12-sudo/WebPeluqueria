@extends('layouts.app')
@section('class-style', 'w-100')
@section('card-style', 'min-width:300px;max-width:700px')

@section('content')
    <h4>Historial de canjeos</h4>
    <div class="table-responsive">
        <table class="table table-striped table-responsive-sm table-hover">
            <thead>
                <tr>
                    <th style="min-width:100px">Fecha</th>
                    <th>Cupón</th>
                    <th>Puntos</th>
                    <th>Validez</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($movimientos as $movimiento)

                    <tr>
                        <td style="min-width:100px">{{ \Carbon\Carbon::parse($movimiento->created_at)->format('d-m-Y H:i') }}
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $movimiento->cupon->titulo)) }}</td>

                        <td>{{ $movimiento->puntos }}€</td>
                        <td>
                            @if ($movimiento->pendiente == true)
                                Pendiente de validación
                            @else
                                Validado
                            @endif
                        </td>


                    </tr>


                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $movimientos->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection