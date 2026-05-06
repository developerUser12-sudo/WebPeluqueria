@extends('layouts.app')
@section('card-style', 'min-width:300px;max-width:1050px')
@section('class-style', 'my-0 my-lg-5')

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

    <div class="d-flex flex-column flex-lg-row gap-3">

        <div class="d-flex flex-column" style="border:1px solid #8B8000;border-radius:15px;max-width:300px;width:100%">
            <h3 class="p-4">Descuentos</h3>

            @foreach ($vales as $vale)
                @if ($vale->tipo == 'descuento')
                    <div class="d-flex flex-row justify-content-between"
                        style="border:1px solid #8B8000;border-left:none;border-right:none;border-bottom:none;height:120px">

                        <div class="p-3 d-flex align-items-center">
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
                                                    {{ str_replace('_', ' ', ucfirst($vale->titulo)) }}. Recuerda que el cupón tiene una validez de 20 días
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
                @endif
            @endforeach
        </div>

        <div class="d-flex flex-column" style="border:1px solid #8B8000;border-radius:15px;max-width:300px;width:100%">
            <h3 class="p-4">Servicios</h3>

            @foreach ($vales as $vale)
                @if ($vale->tipo == 'servicio')
                    <div class="d-flex flex-row justify-content-between"
                        style="border:1px solid #8B8000;border-left:none;border-right:none;border-bottom:none;height:120px">

                        <div class="p-3 d-flex align-items-center">
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
                                                    {{ str_replace('_', ' ', ucfirst($vale->titulo)) }}. Recuerda que el cupón tiene una validez de 20 días
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
                @endif
            @endforeach
        </div>

        {{-- EXTRAS --}}
        <div class="d-flex flex-column" style="border:1px solid #8B8000;border-radius:15px;max-width:300px;width:100%">
            <h3 class="p-4">Extras</h3>

            @foreach ($vales as $vale)
                @if ($vale->tipo == 'extra')
                    <div class="d-flex flex-row justify-content-between"
                        style="border:1px solid #8B8000;border-left:none;border-right:none;border-bottom:none;height:120px">

                        <div class="p-3 d-flex align-items-center">
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
                                                    {{ str_replace('_', ' ', ucfirst($vale->titulo)) }}. Recuerda que el cupón tiene una validez de 20 días
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
                @endif
            @endforeach
        </div>

    </div>
    <div class="mt-3">
        <p >Las ofertas canjeadas serán enviadas a revisión. Cuando sea validada, se te enviará un correo electrónico con el cupón.</p>
    </div>



@endsection