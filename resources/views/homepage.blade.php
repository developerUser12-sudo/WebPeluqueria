@extends('layouts.app')
@section('main-class', 'bg-black')
@section('homepage')

    <div class="main text-light d-flex justify-content-center align-items-center" style="height:75vh">

        <div class="p-5 d-flex flex-column align-items-center gap-4 glass">
            <img src="/storage/logo-sin-fondo.png" alt="Logo">
            <h1>LM Barber</h1>
            <p class="text-center fs-5"><b>Estudio especializado en peluquería masculina y asesoramiento de imagen
                    profesional con tijera</b></p>
            <a class="btn btn-secondary" type="button" href="{{ route('reservar') }}"
                style="border-radius: 12px;background-color:#222322">Reservar</a>
        </div>
    </div>
    <div class="bg-black d-flex justify-content-center flex-column gap-5" style="height:30vh">

        <div class="d-flex flex-md-row flex-column justify-content-md-evenly gap-4 align-items-center">
            <div class="d-flex flex-row gap-5">
                <div>
                    <a href="https://www.instagram.com/lmbarberestudio/" class="text-decoration-none text-light"><i
                            class="bi bi-instagram fs-2"></i></a>
                </div>
                <div>
                    <a href="https://wa.link/gcqpdd" class="text-decoration-none text-light fs-2"><i
                            class="bi bi-whatsapp"></i></a>

                </div>
            </div>
            <div class="text-light ">
                <h3>⭐⭐⭐⭐⭐ | 8 reseñas</h3>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-center gap-5">
            <a href="/politica-de-privacidad" class="text-decoration-none text-light">Política de privacidad</a>
            <a href="/aviso-legal" class="text-decoration-none text-light">Aviso legal</a>
        </div>
    </div>
@endsection