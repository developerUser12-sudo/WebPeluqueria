@extends('layouts.app')
@section('class-style', 'my-0 my-md-5 w-100')
@section('card-style', 'max-width:750px')

@section('content')

    <ul class="nav nav-tabs mb-4 d-flex align-items-center flex-column flex-md-row justify-content-md-start" id="adminTabs"
        role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#citas">
                Citas
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

        <div class="tab-pane fade show active" id="citas">

            <form method="GET" class="mb-3 d-flex gap-2 flex-column flex-md-row">

                <input type="text" name="search" class="form-control" placeholder="Busca por nombre o teléfono..."
                    value="{{ request('search') }}">
                <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">

                <button type="submit" class="btn btn-primary">
                    Buscar
                </button>

                <a href="{{ url()->current() }}" class="btn btn-secondary">
                    Borrar
                </a>

            </form>
            <h5 class="text-light">Citas futuras</h5>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Nombre cliente</th>
                            <th>Telefono cliente</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasFuturas as $citaFutura)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $citaFutura->servicio)) }}</td>
                                <td>{{ ucfirst($citaFutura->peluquero) }}</td>
                                <td>{{ \Carbon\Carbon::parse($citaFutura->dia)->format('d-m-Y') }}</td>
                                <td>{{ $citaFutura->hora }}</td>
                                <td>@if ($citaFutura->nombre != null)
                                {{ $citaFutura->nombre }} @else {{ $citaFutura->user->name }}
                                    @endif
                                </td>
                                <td>@if ($citaFutura->telefono != null)
                                {{ $citaFutura->telefono }} @else {{ $citaFutura->user->phone }}
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('citas.edit', $citaFutura->id) }}" method="GET">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('citas.destroy', $citaFutura->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#eliminarCita{{ $citaFutura->id }}">Eliminar</button>
                                        <div class="modal fade " id="eliminarCita{{ $citaFutura->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content text-white" style="background-color:#222322">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cita</h1>

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
            </div>

            {{ $citasFuturas->links('pagination::bootstrap-5') }}

            <h5 class="text-light">Citas pasadas</h5>

            <div class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Nombre cliente</th>
                            <th>Telefono cliente</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citasPasadas as $citaPasada)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $citaPasada->servicio)) }}</td>
                                <td>{{ ucfirst($citaPasada->peluquero) }}</td>
                                <td>{{ \Carbon\Carbon::parse($citaPasada->dia)->format('d-m-Y') }}</td>
                                <td>{{ $citaPasada->hora }}</td>
                                <td>@if ($citaPasada->nombre != null)
                                {{ $citaPasada->nombre }} @else {{ $citaPasada->user->name }}
                                    @endif
                                </td>
                                <td>@if ($citaPasada->telefono != null)
                                {{ $citaPasada->telefono }} @else {{ $citaPasada->user->phone }}
                                    @endif
                                </td>
                                
                                
                                
                                <td>
                                    <form action="{{ route('citas.edit', $citaPasada->id) }}" method="GET">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('citas.destroy', $citaPasada->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#eliminarCita{{ $citaPasada->id }}">Eliminar</button>
                                        <div class="modal fade " id="eliminarCita{{ $citaPasada->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content text-white" style="background-color:#222322">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cita</h1>

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
                                <td>
                                    @if ($citaPasada->nombre == null)
                                    
                                    <form action="{{ route('admin.servicio-completado', $citaPasada->id) }}" method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-success" {{ $citaPasada->completado==true ? 'disabled' : '' }}>Completado</button>
                                    </form>
                                   
                                    @endif 
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $citasPasadas->links('pagination::bootstrap-5') }}

        </div>

        <div class="tab-pane fade" id="bloqueos">

            <h5 class="text-light">Bloquear franja horaria</h5>

            <form method="POST" action="{{ route('bloqueos.store') }}">
                @csrf

                <select name="tipo" id="tipo" class="form-select mb-3" required>
                    <option value="" selected disabled hidden>Escoge formato</option>
                    <option value="dia_entero">Día completo</option>
                    <option value="franja_horaria">Franja horaria</option>
                </select>

                <div id="franjaHoraria" style="display:none;">
                    <label class="text-light">Inicio</label>
                    <input class="form-control" name="fecha_inicio" id="fecha_inicio" type="datetime-local">

                    <label class="text-light mt-3">Fin</label>
                    <input class="form-control" name="fecha_fin" id="fecha_fin" type="datetime-local">
                </div>

                <div id="diaEntero">
                    <input class="form-control" type="date" id="dia" name="dia">
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
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#eliminarHorario{{ $horarioBloqueado->id }}">Eliminar</button>
                                        <div class="modal fade " id="eliminarHorario{{ $horarioBloqueado->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content text-white" style="background-color:#222322">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar cita</h1>

                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Seguro que quieres eliminar este horario?
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
            </div>

        </div>
        <div class="tab-pane fade" id="estadisticas">

            <h4 class="text-light mb-4">Estadísticas de hoy</h4>

            <div class="row g-3">

                <div class="col-md-6">
                    <div class="card shadow border-0 bg-dark text-light">
                        <div class="card-body text-center">
                            <h6 class="text-secondary">Citas hoy</h6>
                            <h2 class="fw-bold">{{ $citasHoy }}</h2>
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
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">Cerrar sesión</button>
    </form>
    <script>
        const diaInput = document.getElementById('dia');
        const inicioInput = document.getElementById('fecha_inicio');
        const finInput = document.getElementById('fecha_fin');
        document.getElementById('tipo').addEventListener('change', function () {

            if (this.value == 'dia_entero') {
                document.getElementById('diaEntero').style.display = 'block';
                document.getElementById('franjaHoraria').style.display = 'none';
                diaInput.setAttribute('required', true);
                inicioInput.removeAttribute('required');
                finInput.removeAttribute('required');
            } else {
                document.getElementById('diaEntero').style.display = 'none';
                document.getElementById('franjaHoraria').style.display = 'block';
                inicioInput.setAttribute('required', true);
                finInput.setAttribute('required', true);

                diaInput.removeAttribute('required');
            }

        });

    </script>

@endsection