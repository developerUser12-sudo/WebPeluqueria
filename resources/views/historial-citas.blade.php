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
                @php
                    $now = now();
                    $limite = $now->copy()->addHours(2);
                @endphp
                
                @foreach ($citas as $cita)

                    <tr>
                        <td style="min-width:100px">{{ \Carbon\Carbon::parse($cita->dia)->format('d-m-Y') }} - {{ $cita->hora }}
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $cita->servicio)) }}</td>

                        <td>{{ $cita->precio }}€</td>

                        <td>{{ ucwords($cita->peluquero) }}</td>
                        @php
                            $citaDT = \Carbon\Carbon::parse($cita->dia . ' ' . $cita->hora);
                            $puedeCancelar = $citaDT->greaterThan($limite);
                            $citaCancelada=$cita->cancelada;
                        @endphp


                        <td>
                            <form action="{{ route('citaCliente.destroy', $cita->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <input type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#eliminarCita{{ $cita->id }}" style="background-color:#222322"
                                    value="Cancelar" {{ (!$puedeCancelar || $citaCancelada) ? 'disabled' : ''}}>

                                <div class="modal fade " id="eliminarCita{{ $cita->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content text-white" style="background-color:#222322">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar cita</h1>

                                            </div>
                                            <div class="modal-body">
                                                ¿Seguro que quieres cancelar esta cita?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
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
    <small>Las citas que se realicen dentro de dos horas o menos no podrán ser canceladas.</small>
@endsection