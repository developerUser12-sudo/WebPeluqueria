@extends('layouts.app')
@section('main-class', 'bg-black')
@section('homepage')

    <div class="main text-light d-flex justify-content-center align-items-center p-3 transparent-container" >

        <div class="p-5 d-flex flex-column align-items-center gap-4 glass">
            <img src="/storage/logo-sin-fondo.png" alt="Logo de LM Barber">
            <h1>LM Barber</h1>
            <p class="text-center fs-5"><b>Estudio especializado en peluquería masculina y asesoramiento de imagen
                    profesional con tijera</b></p>
            <a class="btn btn-secondary"  href="{{ route('reservar') }}"
                style="border-radius: 12px;background-color:#222322">Reservar</a>
        </div>
    </div>

    <div class="bg-black d-flex justify-content-center flex-column gap-5">


        <div class="d-flex flex-md-row flex-column justify-content-md-evenly gap-4 align-items-center mt-5">
            <div class="d-flex flex-row gap-5">
                <div>
                    <a href="https://www.instagram.com/lmbarberestudio/" class="text-decoration-none text-light"><i
                            class="bi bi-instagram fs-2" aria-label="Instagram de LM Barber"></i></i></a>
                </div>
                <div>
                    <a href="https://wa.link/gcqpdd" class="text-decoration-none text-light fs-2"><i
                            class="bi bi-whatsapp" aria-label="WhatsApp de LM Barber"></i></i></a>

                </div>
            </div>
            <div class="text-light ">
                <h3>⭐⭐⭐⭐⭐ | 29 reseñas</h3>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-center gap-5">
            <a href="/politica-de-privacidad" class="text-decoration-none text-light">Política de privacidad</a>
            <a href="/aviso-legal" class="text-decoration-none text-light">Aviso legal</a>
        </div>
        <div class="d-flex flex-column gap-3 align-items-center mt-3" id="reseñas">

            <div class="p-3 text-light border-bottom" style="min-width:300px;max-width:500px">
                <strong>Alejandro Ruiz</strong>
                <p class="mb-1">★★★★★</p>
                <p class="mb-0">Barbería 100% recomendable, buen trato y un trabajo exquisito. Difícil encontrar algo igual
                    en Utrera.</p>
            </div>

            <div class="p-3 text-light border-bottom" style="min-width:300px;max-width:500px">
                <strong>Ivan Ruiz Perez</strong>
                <p class="mb-1">★★★★★</p>
                <p class="mb-0">Muy bien trato en la barbería y muy profesionales de lo mejor de utrera</p>
            </div>

            <div class="p-3 text-light border-bottom" style="min-width:300px;max-width:500px">
                <strong>Juaky Nunez</strong>
                <p class="mb-1">★★★★★</p>
                <p class="mb-0">De las mejores barberías que he visitado, en utrera muy buena opción</p>
            </div>
            <div class="p-3 text-light border-bottom" style="min-width:300px;max-width:500px">
                <strong>Sergio Ramirez</strong>
                <p class="mb-1">★★★★★</p>
                <p class="mb-0">Perfecto trato, perfecto trabajo y dedicación. Un placer y ha repetir!</p>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const boton = document.getElementById('boton-reseñas');
            const reseñas = document.getElementById('reseñas');

            if (boton && reseñas) {
                boton.addEventListener('click', function () {
                    reseñas.classList.toggle('show');
                });
            }
            if (window.location.hash === '#reseñas') {
                reseñas.classList.add('show');

                reseñas.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>
@endsection