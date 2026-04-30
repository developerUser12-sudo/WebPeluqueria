@extends('layouts.app')

@section('content')
<h2>Historial de canjeos</h2>
@foreach ($movimientos as $movimiento)
<p>{{ $movimiento->id_usuario }}</p>
@endforeach
@endsection