@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex flex-column justify-content-center align-items-center ">
        <div class="bg-black p-5 rounded-4 d-flex flex-column gap-5 mt-5 mb-5">
            <div>
                <h5 class="text-light">Citas futuras</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Peluquero</th>
                            <th>Dia</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasFuturas as $citaFutura)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $citaFutura->servicio)) }}</td>
                                <td>{{ ucwords($citaFutura->peluquero) }}</td>
                                <td>{{ $citaFutura->dia }}</td>
                                <td>{{ $citaFutura->hora }}</td>
                                <td>
                                    <form action="{{ route('citas.edit', $citaFutura->id) }}" method="GET">
                                        <button type="submit" class="btn btn-warning ">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('citas.destroy', $citaFutura->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#eliminarCita">
                                            Eliminar
                                        </button>
                                        <div class="modal fade" id="eliminarCita" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cita</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Seguro que quieres eliminar esta cita?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                    {{ $citasFuturas->links() }}
                </div>
                <h5 class="text-light">Citas pasadas</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Peluquero</th>
                            <th>Dia</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasPasadas as $citaPasada)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $citaPasada->servicio)) }}</td>
                                <td>{{ ucwords($citaPasada->peluquero) }}</td>
                                <td>{{ $citaPasada->dia }}</td>
                                <td>{{ $citaPasada->hora }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $citasPasadas->links() }}
                </div>
            </div>
            <div>
                <h4 class="text-light">Bloquear franja horaria</h4>
                <form method="POST" action="{{ route('bloqueos.store') }}">
                    @csrf
                    <div class="form-group mt-3 ">
                        <select name="tipo" id="tipo" class="mb-3 form-select">
                            <option value="dia_entero">Día completo</option>
                            <option value="franja_horaria">Franja horaria</option>
                        </select>
                        <div id="franjaHoraria" style="display:none;">
                            <label class="text-light mt-2" for="inicio">Inicio</label>
                            <input class="form-control" name="fecha_inicio" id="inicio" type="datetime-local">
                            <label class="text-light mt-4" for="fin">Fin</label>
                            <input class="form-control" name="fecha_fin" id="fin" type="datetime-local">
                        </div>
                        <div id="diaEntero">
                            <input class="form-control" type="date" name="dia" class="mt-2">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Crear bloqueo de horario</button>
                </form>
            </div>
            <div>
                <h4 class="text-light">Estadisticas diarias</h4>
                <p class="text-light">Citas de hoy: {{ count($citasHoy) }}</p>
                <p class="text-light">Total de precios de hoy: {{ $totalHoy }}€</p>

            </div>
            <div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class=" btn btn-danger">{{ __('Cerrar sesión') }}</button>
                </form>
            </div>
        </div>



    </div>
    <script>
        document.getElementById('tipo').addEventListener('change', function () {
            if (this.options[this.selectedIndex].value == 'dia_entero') {
                document.getElementById('diaEntero').style.display = 'block';
                document.getElementById('franjaHoraria').style.display = 'none';
            }
            else if (this.options[this.selectedIndex].value == 'franja_horaria') {
                document.getElementById('diaEntero').style.display = 'none';
                document.getElementById('franjaHoraria').style.display = 'block';

            }
        })
    </script>
@endsection