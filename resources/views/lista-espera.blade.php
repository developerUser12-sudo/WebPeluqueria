@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('lista-espera.create') }}" id="form-reserva">
        @csrf
        <h5>Lista de espera</h5>
        <p>Selecciona un tramo horario</p>
        <div class="form-group">
            <label for="inicio" class="text-light">De: </label>
            <input id="inicio" type="time" name="inicio" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="fin" class="text-light">A: </label>
            <input type="time" name="fin" id="fin" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="email" class="text-light">Correo electrónico</label>
            <input id="email" type="email" name="email" class="form-control" required>
            <small class="text-danger mt-2 " id="correo-error"></small>
        </div>
        <div class="mt-3">
            <a href="{{ route('reservar') }}" class="btn btn-secondary">Atrás</a>
            <input id="confirmar" type="submit" value="Confirmar" class="btn btn-success">
        </div>
        <small class="text-danger" id="error"></small>
        <input type="hidden" name="dia" value="{{ request('dia') }}">
        <input type="hidden" name="peluquero" value="{{ request('peluquero') }}">
        <input type="hidden" name="nombre" value="{{ request('nombre') }}">
        <input type="hidden" name="apellido" value="{{ request('apellido') }}">
        <input type="hidden" name="telefono" value="{{ request('telefono') }}">
        <p class="mt-3">Serás notificado mediante correo electrónico cuando haya una cita libre<br> en el tramo horario que
            elijas.</p>
    </form>
    <script>

        const usuarios = @json($usuarios);
        const emailInput = document.getElementById('email');
        const correoError = document.getElementById('correo-error');

        document.getElementById('form-reserva').addEventListener('submit', function (e) {
            let inicio = document.getElementById('inicio').value;
            let fin = document.getElementById('fin').value;
            let error=false;
            if (inicio >= fin) {
                e.preventDefault();
                document.getElementById('error').textContent = 'Hora seleccionada incorrecta';
            }
            for (let i = 0; i < usuarios.length; i++) {
                if (usuarios[i].email == emailInput.value) {
                    correoError.textContent = 'Correo existente';
                    error=true;
                    
                }
            }
            if (error) {
                e.preventDefault();
                
            }
        })

    </script>
@endsection