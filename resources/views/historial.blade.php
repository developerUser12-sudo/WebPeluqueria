@extends('layouts.app')
@section('class-style', 'w-100')
@section('card-style', 'min-width:300px;max-width:700px')

@section('content')
    <h4>Historial de citas</h4>
    <div class="table-responsive">
        <table class="table table-striped table-responsive-sm table-hover">
            <thead>
                <tr>
                    <th style="min-width:100px">Fecha</th>
                    <th>Servicio</th>
                    <th>Precio</th>
                    <th>Profesional</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)

                    <tr>
                        <td style="min-width:100px">{{ \Carbon\Carbon::parse($cita->dia)->format('d-m-Y') }} - {{ $cita->hora }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $cita->servicio)) }}</td>

                        <td>{{ $cita->precio }}€</td>

                        <td>{{ ucwords($cita->peluquero) }}</td>
                        @php
                            $citaDT = \Carbon\Carbon::parse($cita->dia . ' ' . $cita->hora);
                            $puedeCancelar = now()->diffInMinutes($citaDT, false) > 120;
                        @endphp
                        <td>
                            <form action="{{ route('citaCliente.destroy', $cita->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#eliminarCita" style="background-color:#222322" value="Cancelar"
                                    @if(!$puedeCancelar) disabled @endif>

                                <div class="modal fade" id="eliminarCita" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cita</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Seguro que quieres eliminar esta cita?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>


                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $citas->links('pagination::bootstrap-5') }}
        </div>
        
    </div>
    <small>Las citas que sean dentro de dos horas o menos no podrán ser canceladas</small>
@endsection