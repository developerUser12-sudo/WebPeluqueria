@extends('layouts.app')
@section('class-style', 'my-0 my-md-5 w-100')
@section('card-style', 'max-width:650px')

@section('content')

    <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#futuras">
                Citas futuras
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pasadas">
                Citas pasadas
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bloqueos">
                Bloqueos horarios
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#estadisticas">
                Estadisticas
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade show active" id="futuras">

            <h5 class="text-light">Citas futuras</h5>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasFuturas as $citaFutura)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $citaFutura->servicio)) }}</td>
                                <td>{{ ucfirst($citaFutura->peluquero) }}</td>
                                <td>{{ $citaFutura->dia }}</td>
                                <td>{{ $citaFutura->hora }}</td>
                                <td>
                                    <form action="{{ route('citas.edit', $citaFutura->id) }}" method="GET">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('citas.destroy', $citaFutura->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $citasFuturas->links('pagination::bootstrap-5') }}

        </div>

        <div class="tab-pane fade" id="pasadas">

            <h5 class="text-light">Citas pasadas</h5>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasPasadas as $citaPasada)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $citaPasada->servicio)) }}</td>
                                <td>{{ ucfirst($citaPasada->peluquero) }}</td>
                                <td>{{ $citaPasada->dia }}</td>
                                <td>{{ $citaPasada->hora }}</td>
                                <td>
                                    <form action="{{ route('citas.edit', $citaPasada->id) }}" method="GET">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('citas.destroy', $citaPasada->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $citasPasadas->links('pagination::bootstrap-5') }}

        </div>


        <div class="tab-pane fade" id="bloqueos">

            <h4 class="text-light">Bloquear franja horaria</h4>

            <form method="POST" action="{{ route('bloqueos.store') }}">
                @csrf

                <select name="tipo" id="tipo" class="form-select mb-3">
                    <option value="dia_entero">Día completo</option>
                    <option value="franja_horaria">Franja horaria</option>
                </select>

                <div id="franjaHoraria" style="display:none;">
                    <label class="text-light">Inicio</label>
                    <input class="form-control" name="fecha_inicio" type="datetime-local">

                    <label class="text-light mt-3">Fin</label>
                    <input class="form-control" name="fecha_fin" type="datetime-local">
                </div>

                <div id="diaEntero">
                    <input class="form-control" type="date" name="dia">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Crear bloqueo</button>
            </form>


            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horariosBloqueados as $horarioBloqueado)
                            <tr>
                                <td>{{ str_replace('_', ' ', ucfirst($horarioBloqueado->tipo)) }}</td>
                                <td>{{ $horarioBloqueado->fecha_inicio }}</td>
                                <td>{{ $horarioBloqueado->fecha_fin }}</td>
                                <td>
                                    <form action="{{ route('horarioBloqueado.destroy', $horarioBloqueado->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger mt-3">Cerrar sesión</button>
            </form>

        </div>
        <div class="tab-pane fade" id="estadisticas">

            <h4 class="text-light mb-4">Estadísticas de hoy</h4>

            <div class="row g-3">

                <div class="col-md-6">
                    <div class="card shadow border-0 bg-dark text-light">
                        <div class="card-body text-center">
                            <h6 class="text-secondary">Citas hoy</h6>
                            <h2 class="fw-bold">{{ count($citasHoy) }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow border-0 bg-dark text-light">
                        <div class="card-body text-center">
                            <h6 class="text-secondary">Ingresos hoy</h6>
                            <h2 class="fw-bold text-success">{{ $totalHoy }}€</h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>

    <script>
        document.getElementById('tipo').addEventListener('change', function () {

            if (this.value == 'dia_entero') {
                document.getElementById('diaEntero').style.display = 'block';
                document.getElementById('franjaHoraria').style.display = 'none';
            } else {
                document.getElementById('diaEntero').style.display = 'none';
                document.getElementById('franjaHoraria').style.display = 'block';
            }

        });
    </script>

@endsection