@extends('layouts.app')
@section('card-style', 'width:500px')

@section('content')
    <h3 class="mb-3">Editando cita</h3>
    <form action="{{ route('citas.update', $cita->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="servicio" class="text-light">Servicio:</label>
            <select class="form-control" name="servicio" id="servicio">
                <option value="{{ $cita->servicio }}" selected disabled hidden>
                    {{ ucwords(str_replace('_', ' ', $cita->servicio)) }}
                </option>
                <option value="afeitado_de_cabeza_y_barba">
                    Afeitado
                    de cabeza + barba</option>
                <option value="arreglo_de_barba">
                    Arreglo de barba</option>
                <option value="corte_y_barba">
                    Corte + barba</option>
                <option value="corte_y_barba_ritual">
                    Corte + barba ritual</option>
                <option value="corte_de_pelo">
                    Corte de pelo</option>
            </select>
        </div>
        <div class="form-group mt-3">

            <label for="peluquero" class="text-light">Profesional:</label>
            <select class="form-control" name="peluquero" id="peluquero">
                <option value="{{ $cita->peluquero }}" selected disabled hidden>
                    {{ ucwords($cita->peluquero) }}
                </option>
                <option value="luis">Luis</option>
                <option value="hugo">Hugo</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <label class="text-light" for="dia">Selecciona un día</label>
            <input type="date" value="{{ $cita->dia }}" id="dia" name="dia" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label class="text-light" for="hora">Selecciona una hora</label>
            <input type="time" value="{{ $cita->hora }}" id="hora" name="hora" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
    </form>

@endsection