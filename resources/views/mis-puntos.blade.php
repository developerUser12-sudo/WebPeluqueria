@extends('layouts.app')
@section('card-style', 'min-width:320px;max-width:1050px')
@section('class-style', 'my-0 my-md-5')

@section('content')
    @php
        function porcentaje($meta, $puntos)
        {
            return min(100, ($puntos / $meta) * 100);
        }

        function faltan($meta, $puntos)
        {
            return max(0, $meta - $puntos);
        }
    @endphp

    <div class="text-center">
        <h3>Tus puntos:</h3>
        <h1 class="fw-bold mt-3 mb-5">{{ $user->puntos }}</h1>
    </div>
    <hr>
    <h3 class="mb-4">Descuentos</h3>
    <div class="d-flex flex-wrap gap-2 justify-content-center">

        @foreach ($vales as $vale)
            <div class="d-flex flex-row justify-content-between"
                style="height:180px;border:1px solid #8B8000;border-radius:15px;width:310px">

                <div class="p-3 d-flex align-items-center" style="min-width:80px">
                    {{ $vale->puntos }} puntos - {{ str_replace('_', ' ', ucfirst($vale->titulo)) }}
                </div>

                <div class="p-3 d-flex align-items-center">
                    @if (faltan($vale->puntos, $user->puntos) > 0)

                        <button class="btn position-relative text-white w-100 overflow-hidden boton-oferta"
                            style="background:#222322;border:none">

                            <div class="position-absolute top-0 start-0 h-100"
                                style="width:{{ porcentaje($vale->puntos, $user->puntos) }}%;background:#8B8000;z-index:1;">
                            </div>

                            <span class="position-relative" style="z-index:2;">
                                Faltan {{ faltan($vale->puntos, $user->puntos) }} pts
                            </span>
                        </button>

                    @else

                        <button type="button" class="btn position-relative text-white w-100 overflow-hidden boton-oferta"
                            style="background:#222322;border:none" data-bs-toggle="modal"
                            data-bs-target="#canjear-recompensa{{ $vale->id }}">

                            <div class="position-absolute top-0 start-0 h-100" style="width:100%;background:#8B8000;z-index:1;">
                            </div>

                            <span class="position-relative" style="z-index:2;">Canjear</span>
                        </button>

                        <div class="modal fade" id="canjear-recompensa{{ $vale->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content text-white" style="background:#222322">
                                    <form action="{{ route('canjear', $vale->id)}}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title">Canjear recompensa</h5>
                                        </div>

                                        <div class="modal-body">
                                            ¿Estás seguro de que quieres canjear esta recompensa?
                                            {{ str_replace('_', ' ', ucfirst($vale->titulo)) }}
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>


                                            <button type="submit" class="btn btn-primary">
                                                Canjear
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        @endforeach
    </div>

    <h3 class="mb-4 mt-5">Otras ofertas</h3>
    <div class="d-flex flex-wrap gap-2 justify-content-center">
        <div class="p-3"
            style="height:145px;border:1px solid #8B8000;border-radius:15px;width:310px">
            ⭐ Deja una reseña en Google Maps - 20 puntos (solo una vez)
        </div>
        <div class="p-3"
            style="height:145px;border:1px solid #8B8000;border-radius:15px;width:310px">
            👤 Trae un cliente nuevo - 40 puntos (cuando realice su primer servicio)
        </div>
        <div class="p-3"
            style="height:145px;border:1px solid #8B8000;border-radius:15px;width:310px">
            📱 Sube una historia a Instagram etiquetando a @lmbarberestudio - 5 puntos (máximo 1 vez por semana)
        </div>
    </div>


    <div class="mt-5">
        <p>Las ofertas canjeadas serán enviadas a revisión. Cuando sea validada, se te enviará un correo electrónico con el
            cupón. Todas las ofertas serán canjeadas en la peluquería.</p>
    </div>



@endsection