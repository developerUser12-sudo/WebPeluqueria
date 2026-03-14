@extends('layouts.app')

@section('content')

    <h4 class="text-light text-center fw-bold">Has reservado tu cita en LM Barber</h4>
    <p class="text-light text-center">Añadir al calendario</p>
    @php
        $inicio = \Carbon\Carbon::parse($cita->dia . ' ' . $cita->hora);
        $fin = $inicio->copy()->addMinutes(30);

        $inicioGoogle = $inicio->format('Ymd\THis');
        $finGoogle = $fin->format('Ymd\THis');
    @endphp
    <div class="d-flex flex-row justify-content-center gap-5">
        <a class="text-decoration-none" target="_blank"
            href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Cita+Peluqueria&dates={{ $inicioGoogle }}/{{ $finGoogle }}&details=Cita+para+{{ str_replace('_', ' ', $cita->servicio) }}&location=LM+Barber">

            <i class="bi bi-google fs-2 text-light"></i>
        </a>
        <a target="_blank" href="{{ route('calendario', $cita->id) }}">
            <i class="bi bi-apple fs-2 text-light"></i>
        </a>

    </div>
    <small class=" mt-2 text-light">
        Para Apple Calendar, descarga el archivo y ábrelo/importalo.
    </small>
    <table class="mt-2 table table-striped">
        <tr class="table-secondary">
            <th>Servicio</th>
            <td>{{ ucwords(str_replace('_', ' ', $cita->servicio)) }}</td>
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
        <tr class="table-secondary">
            <th>Precio</th>
            <td>{{ $cita->precio }}€</td>
        </tr>
    </table>
    <a href="{{  url('/') }}" type="button" class="btn btn-secondary"
        style="border-radius: 12px;background-color:#222322">Volver</a>

@endsection