@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex flex-column justify-content-center align-items-center ">
        <div class="bg-black p-5 rounded-4 ">
            <h4 class="text-light">Bloquear franja horaria</h4>
            <form method="POST" action="{{ route('bloqueos.store') }}">
                @csrf
                <div class="form-group">
                    <label class="text-light mt-2" for="inicio">Inicio</label>
                    <input class="form-control" name="fecha_inicio" id="inicio" type="datetime-local" required>
                    <label class="text-light mt-4" for="fin">Fin</label>
                    <input class="form-control" name="fecha_fin" id="fin" type="datetime-local" required>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Crear bloqueo de horario</button>
            </form>
        </div>
        <div class="bg-black p-5 rounded-4 ">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class=" btn btn-danger">{{ __('Cerrar sesión') }}</button>
            </form>
        </div>
    </div>
@endsection