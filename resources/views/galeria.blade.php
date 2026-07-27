@extends('layouts.app')
@section('card-style', 'min-width:300px;max-width:1050px')
@section('class-style', 'my-0 my-lg-5')
@section('content')
    <h2 class="mb-4">Galería</h2>
    <div class="mt-5">
        <hr>
    <h4>Fotos</h4>
    <hr>
    </div>
    <div class="d-flex  justify-content-center align-items-center">
        <div class="d-flex flex-column gap-3  flex-sm-row ">
            <div>
                <img class="img-galeria" src="/storage/foto-galeria-1.webp" alt="Corte de pelo realizado en LM Barber"
                    loading="lazy">
            </div>
            <div>
                <img class="img-galeria" src="/storage/foto-galeria-2.webp" alt="Corte de pelo realizado en LM Barber"
                    loading="lazy">
            </div>

        </div>
    </div>
    <div class="mt-5">
        <hr>
        <h4>Vídeos</h4>
        <hr>
    </div>
    <div class="d-flex justify-content-center align-items-center">

        <div class="d-flex align-items-center flex-wrap gap-3 justify-content-center">
            <div class="video-wrapper">

                <video autoplay muted loop playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-1_hw5jj9.mp4"
                        type="video/mp4">
                    Tu navegador no soporta la reproducción de vídeo.
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-2_ri5rgw.mp4"
                        type="video/mp4">
                    Tu navegador no soporta la reproducción de vídeo.
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-3_rl1sp6.mp4"
                        type="video/mp4">
                    Tu navegador no soporta la reproducción de vídeo.
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566118/video-galeria-4_npd1al.mp4"
                        type="video/mp4">
                    Tu navegador no soporta la reproducción de vídeo.
                </video>
            </div>

        </div>
    </div>



@endsection