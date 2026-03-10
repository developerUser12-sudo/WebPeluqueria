@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 " style="width:500px">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab">Correo electrónico</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab">Contraseña</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab">Datos</button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active text-light" id="home" role="tabpanel">
                    <input type="text" class="text-dark form-control w-75" value="{{ $user->email }}" readonly>
                    <form action="">
                        <input type="submit" class="btn btn-secondary mt-3"
                            style="border-radius: 12px;background-color:#222322" value="Cambiar dirección de correo">
                    </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <form method="POST" action="{{ route('cuenta.password') }}">
                        @csrf
                        @method('PATCH')
                        <input type="password" name="password" placeholder="Nueva contraseña" required class="form-control">
                        <input type="password" name="password_confirmation" placeholder="Confirmar nueva contraseña"
                            class="form-control mt-3" required>

                        <input type="submit" class="btn btn-secondary mt-3"
                            style="border-radius: 12px;background-color:#222322" value="Cambiar contraseña">

                    </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    Contenido de datos
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif
        </div>
    </div>
@endsection