@extends('layouts.app')

@section('content')
    <div class="main text-light d-flex justify-content-center align-items-center">

        <div class="p-5 d-flex flex-column align-items-center gap-5 glass">
            <h1>LM Barber</h1>
            <p class="text-center fs-5"><b>Estudio especializado en peluquería masculina y asesoramiento de imagen
                    profesional con tijera</b></p>
            <button class="btn btn-secondary" style="border-radius: 12px;background-color:#222322">Reservar</button>
        </div>
    </div>
    <div class="bg-black d-flex align-items-center" style="height:30vh">

        <div class="d-flex flex-row justify-content-evenly w-100">
            <div class="d-flex flex-row gap-5">
                <div>
                    <a href="https://www.instagram.com/lmbarberestudio/" class="text-decoration-none text-light"><i class="bi bi-instagram fs-2"></i></a>
                </div>
                <div>
                    <a href="https://wa.link/gcqpdd" class="text-decoration-none text-light fs-2"><i class="bi bi-whatsapp"></i></a>

                </div>
            </div>
            <div class="text-light">
                Valoraciones google maps
            </div>
        </div>
    </div>
@endsection