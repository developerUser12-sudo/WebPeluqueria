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
        <div class="tab-pane fade show active text-light" id="correo" style="max-width:200px">
            <form method="POST" action="{{ route('cuenta.email') }}">
                <label for="current-email">Dirección de correo actual</label>
                <input id="current-email" type="text" class="text-dark form-control w-100" value="{{ $user->email }}"
                    readonly>
                @csrf
                @method('PATCH')
                <label class="mt-3" for="new-email">Nueva dirección de correo</label>
                <input id="new-email" name="email" type="email" class="text-dark form-control  w-100">
                @error('email')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
                <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                    value="Cambiar correo">
            </form>
        </div>

        <div class="tab-pane fade text-light" id="password" style="max-width:200px">
            <form method="POST" action="{{ route('cuenta.password') }}">
                @csrf
                @method('PATCH')
                <div>
                    <label for="password">Nueva contraseña</label>
                    <input id="password" type="password" name="password" class="form-control w-100" required>
                </div>
                <div class="mt-3">
                    <label for="confirm-password">Confirmar nueva contraseña</label>
                    <input id="confirm-password" type="password" name="password_confirmation" class="form-control w-100"
                        required>
                    @error('password')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>
                <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                    value="Cambiar contraseña">
            </form>
        </div>

        <div class="tab-pane fade text-light" id="datos" style="max-width:200px">
            <form method="POST" action="{{ route('cuenta.datos') }}">
                @csrf
                @method('PATCH')

                <label>Nombre</label>
                <input type="text" name="name" class="form-control text-dark w-100" placeholder="{{ $user->name }}">

                <label class="mt-3">Apellido</label>
                <input type="text" name="surname" class="form-control text-dark w-100" placeholder="{{ $user->surname }}">

                <label class="mt-3">Teléfono (9 digitos sin espacios)</label>
                <input type="text" name="phone" class="form-control text-dark w-100" placeholder="{{ $user->phone }}">
                @error('phone')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
                <input type="submit" class="btn btn-secondary mt-3" style="border-radius:12px;background-color:#222322"
                    value="Actualizar datos">
            </form>
        </div>
    </div>




@endsection