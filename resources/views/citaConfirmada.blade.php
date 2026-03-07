@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 " style="width:450px">
            <h4 class="text-light text-center fw-bold">Has reservado tu cita en LM Barber</h4>
            <p class="text-light text-center">Añadir al calendario</p>
            <table class="table table-striped">
                <tr class="table-secondary">
                    <th>Servicio</th>
                    <td>{{ ucwords(str_replace('_',' ',$cita->servicio)) }}</td>
                </tr>
                <tr class="table-secondary">
                    <th>Peluquero</th>
                    <td>{{ ucwords($cita->peluquero) }}</td>
                </tr>
                <tr class="table-secondary">
                    <th>Día</th>
                    <td>{{ \Carbon\Carbon::parse($cita->dia)->format('d-m-Y') }}</td>
                </tr>
                <tr class="table-secondary">
                    <th>Hora</th>
                    <td>{{ $cita->hora }}</td>
                </tr>
            </table>
            <a href="{{  url('/') }}" type="button" class="btn btn-secondary" style="border-radius: 12px;background-color:#222322">Volver</a>
        </div>
    </div>
@endsection