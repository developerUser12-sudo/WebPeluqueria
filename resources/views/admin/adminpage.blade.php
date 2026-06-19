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
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aviso">
                Aviso a clientes
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#canjeos">
                Canjeos
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
            <h4 class="text-light">Citas futuras</h4>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Nombre usuario</th>
                            <th>Telefono usuario</th>
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

            <h4 class="text-light">Citas pasadas</h4>

            <div class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Nombre usuario</th>
                            <th>Telefono usuario</th>

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

                                            <button type="submit" class="btn btn-success" {{ $citaPasada->completado == true ? 'disabled' : '' }}>Completado</button>
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

            <h4 class="text-light">Bloquear franja horaria</h4>
            <h5 class="mb-3">Importante: al bloquear una franja horaria, la fecha de inicio y de fin deben corresponder al
                mismo dia</h5>
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
                <div class="mt-3  text-black">
                    <select name="profesional" class="form-select" id="">
                        <option value="" selected disabled hidden>Aplicar a un profesional</option>
                        <option value="luis">Luis</option>
                        <option value="hugo">Hugo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Crear bloqueo</button>
            </form>


            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Profesional</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horariosBloqueados as $horarioBloqueado)
                            <tr>
                                <td>{{ str_replace('_', ' ', ucfirst($horarioBloqueado->tipo)) }}</td>
                                <td>{{ ucfirst($horarioBloqueado->profesional) ? ucfirst($horarioBloqueado->profesional) : 'Ambos' }}
                                </td>
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
        <div class="tab-pane fade" id="aviso">

            <h4 class="text-light mb-4">Enviar aviso a todos los usuarios</h4>

            <form class="row" action="{{ route('mensaje') }}" method="POST">
                @csrf
                <div class="col-3">
                    <textarea cols="28" rows="4" class="text-black" class="form-control" type="textarea"
                        name="cuerpo"></textarea>
                    <button type="submit" class="btn btn-secondary" style="background-color:#222322">Enviar</button>
                </div>
            </form>

        </div>
        <div class="tab-pane fade" id="canjeos">
            <form method="GET" class="mb-3 d-flex gap-2 flex-column flex-md-row">

                <input type="text" name="search" class="form-control" placeholder="Busca cupón..."
                    value="{{ request('search') }}">
                <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">

                <button type="submit" class="btn btn-primary">
                    Buscar
                </button>

                <a href="{{ url()->current() }}" class="btn btn-secondary">
                    Borrar
                </a>

            </form>
            <h4 class="text-light mb-4">Canjeos sin validar</h4>

            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cupón</th>
                            <th>Puntos</th>
                            <th>Nombre usuario</th>
                            <th>Telefono usuario</th>
                            <th>Fecha</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientosPendientes as $movimiento)
                            @if ($movimiento->motivo == 'canjeo' && $movimiento->pendiente == true)
                                <tr>
                                    <td>{{ ucfirst($movimiento->cupon->titulo) }}</td>
                                    <td>{{ $movimiento->puntos }}</td>
                                    <td>{{ $movimiento->user->name }}</td>
                                    <td>{{ $movimiento->user->phone }}</td>
                                    <td>{{ $movimiento->created_at->format('d-m-Y H:i') }}</td>
                                    <td>


                                        <form action="{{ route('validar', $movimiento->id) }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#eliminarHorario{{ $movimiento->id }}">Validar</button>
                                            <div class="modal fade " id="eliminarHorario{{ $movimiento->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog ">
                                                    <div class="modal-content text-white" style="background-color:#222322">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Validar cupón</h1>

                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Seguro que quieres validar este cupón?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Validar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $movimientosPendientes->links('pagination::bootstrap-5') }}
            <h4 class="text-light mb-4">Canjeos validados</h4>

            <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cupón</th>
                            <th>Cupón generado</th>
                            <th>Puntos</th>
                            <th>Nombre usuario</th>
                            <th>Telefono usuario</th>
                            <th>Fecha</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientosValidados as $movimiento)
                            @if ($movimiento->motivo == 'canjeo' && $movimiento->pendiente == false)
                                <tr>
                                    <td>
                                        {{ ucfirst($movimiento->cupon->titulo) }}
                                    </td>
                                    <td>
                                        {{ ucfirst($movimiento->cupongenerado->cupon) }}
                                    </td>
                                    <td>
                                        {{ ucfirst($movimiento->cupon->puntos) }}
                                    </td>

                                    <td>{{ $movimiento->user->name }}</td>
                                    <td>{{ $movimiento->user->phone }}</td>
                                    <td>{{ $movimiento->cupongenerado->created_at->format('d-m-Y H:i') }}</td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $movimientosValidados->links('pagination::bootstrap-5') }}

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
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let activeTab = localStorage.getItem('activeTab');

            if (activeTab) {
                let tabTrigger = document.querySelector('[data-bs-target="' + activeTab + '"]');
                if (tabTrigger) {
                    tabTrigger.click();
                }
            }
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (tab) {
                tab.addEventListener('click', function () {
                    localStorage.setItem('activeTab', this.getAttribute('data-bs-target'));
                });
            });

        });
    </script>
@endsection