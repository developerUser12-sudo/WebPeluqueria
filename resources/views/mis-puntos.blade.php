@extends('layouts.app')

@section('content')
<div>

    <h2>Mis puntos</h2>
    <p class="text-center mb-2">Puntos: {{ $user->puntos }}</p>
</div>
@endsection