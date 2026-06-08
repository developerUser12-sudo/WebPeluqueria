@extends('layouts.app')
@section('card-style', 'min-width:300px;max-width:1050px')
@section('class-style', 'my-0 my-lg-5')
@section('content')
    <h2 class="mb-4">Galería</h2>

    <div class="d-flex flex-column justify-content-center align-items-center gap-5">
        <div class="d-flex flex-column flex-sm-row gap-3">
            <div >
                <img src="/storage/foto-galeria-1.webp" alt="Foto galeria 1">
            </div>
            <div >
                <img src="/storage/foto-galeria-2.webp" alt="Foto galeria 2">
            </div>

        </div>
        <div class="d-flex align-items-center flex-column gap-3">
            <div class="video-wrapper">

                <video autoplay muted loop playsinline webkit-playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-1_hw5jj9.mp4"
                        type="video/mp4">
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline webkit-playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-2_ri5rgw.mp4"
                        type="video/mp4">
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline webkit-playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-3_rl1sp6.mp4"
                        type="video/mp4">
                </video>
            </div>
            <div class="video-wrapper">

                <video autoplay muted loop playsinline webkit-playsinline>
                    <source src="https://res.cloudinary.com/dajh0uyig/video/upload/v1777566118/video-galeria-4_npd1al.mp4"
                        type="video/mp4">
                </video>
            </div>

        </div>
    </div>
    

@endsection