@extends('layouts.app')
@section('card-style', 'width:500px')

@section('content')
    <h3 class="mb-3">Editando puntos usuario</h3>
    <form action="{{ route('puntos.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label  class="text-light">Nombre:</label>
            <input class="form-control" type="text" readonly value="{{ $usuario->name }}">
        </div>
        <div class="form-group mt-3">
            <label  class="text-light">Correo:</label>
            <input class="form-control" type="text" readonly value="{{ $usuario->email }}">
        </div>
        <div class="form-group mt-3">
            <label  class="text-light">Teléfono:</label>
            <input class="form-control" type="text" readonly value="{{ $usuario->phone }}">
        </div>
        <div class="form-group mt-3">
            <label for="puntos" class="text-light">Puntos:</label>
            <input class="form-control" id="puntos" name="puntos" type="number"  value="{{ $usuario->puntos }}">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="/admin" style="background-color:#222322" class="btn btn-secondary mt-3">Volver</a>
    </form>
@endsection