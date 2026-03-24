@extends('layouts.app')
@section('class-style', 'd-flex flex-column align-items-center my-0 my-md-5')

@section('content')

    <h4 class="text-light text-center">Ajustes de cuenta</h4>

    <ul class="nav nav-tabs mt-4 d-flex justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#correo" type="button">
                Cambiar correo
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password" type="button">
                Cambiar contraseña
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#datos" type="button">
                Datos personales
            </button>
        </li>
    </ul>


    <div class="tab-content mt-4">
        <div class="tab-pane fade show active text-light" id="correo">
            <label for="current-email">Dirección de correo actual</label>
            <input id="current-email" type="text" class="text-dark form-control " value="{{ $user->email }}" readonly>
            <div class="mt-3">
                <form method="POST" action="{{ route('cuenta.email') }}">
                    @csrf
                    @method('PATCH')
                    <label for="new-email">Nueva dirección de correo</label>
                    <input id="new-email" name="email" type="email" class="text-dark form-control  ">
                    <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                        value="Cambiar dirección de correo">
                </form>
            </div>
        </div>

        <div class="tab-pane fade text-light" id="password">
            <form method="POST" action="{{ route('cuenta.password') }}">
                @csrf
                @method('PATCH')
                <div>
                    <label for="password">Nueva contraseña</label>
                    <input id="password" type="password" name="password" class="form-control " required>
                </div>
                <div class="mt-3">
                    <label for="confirm-password">Confirmar nueva contraseña</label>
                    <input id="confirm-password" type="password" name="password_confirmation" class="form-control "
                        required>
                </div>
                <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                    value="Cambiar contraseña">
            </form>
        </div>

        <div class="tab-pane fade text-light" id="datos">
            <form method="POST" action="{{ route('cuenta.datos') }}">
                @csrf
                @method('PATCH')

                <label>Nombre</label>
                <input type="text" name="name" class="form-control text-dark " placeholder="{{ $user->name }}">

                <label class="mt-3">Apellido</label>
                <input type="text" name="surname" class="form-control text-dark " placeholder="{{ $user->surname }}">

                <label class="mt-3">Teléfono</label>
                <input type="text" name="phone" class="form-control text-dark " placeholder="{{ $user->phone }}">

                <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                    value="Actualizar datos">
            </form>
        </div>
    </div>

    <div class="position-relative w-100 mt-3" >
        @if(session('success'))
            <div id="flash-success"
                class="alert alert-success alert-dismissible fade show shadow-sm position-absolute top-0 start-50 translate-middle-x"
                style="border-radius: 12px; z-index: 1000; transition: all 0.5s ease;" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>

            <script>
                setTimeout(() => {
                    const flash = document.getElementById('flash-success');
                    if (flash) {
                        flash.style.opacity = '0';
                        flash.style.transform = 'translateY(-20px)';
                        setTimeout(() => flash.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif
    </div>


@endsection