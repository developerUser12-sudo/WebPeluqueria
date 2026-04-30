@extends('layouts.app')
@section('card-style', 'min-width:300px;max-width:1050px')
@section('class-style', 'my-0 my-lg-5')
@section('content')
    <h2 class="mb-4">Galería</h2>

    <div class="d-flex flex-column">
        <div class="row gap-3">
            <div class="col-sm">
                <img src="/storage/foto-galeria-1.webp" alt="Foto galeria 1">
            </div>
            <div class="col-sm">
                <img src="/storage/foto-galeria-2.webp" alt="Foto galeria 2">
            </div>

        </div>
        <div class="row gap-3">

            <div class="tiktok-wrapper">
                <video id="videoPlayer" autoplay muted loop playsinline webkit-playsinline></video>

                <button id="prevBtn">▲ </button>
                <button id="nextBtn">▼</button>
            </div>

        </div>
    </div>
    <script>
        const videos = [
            "https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-1_hw5jj9.mp4",
            "https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-2_ri5rgw.mp4",
            "https://res.cloudinary.com/dajh0uyig/video/upload/v1777566117/video-galeria-3_rl1sp6.mp4",
            "https://res.cloudinary.com/dajh0uyig/video/upload/v1777566118/video-galeria-4_npd1al.mp4"
        ];

        let index = 0;
        const player = document.getElementById("videoPlayer");
        function loadVideo(i) {
            if (player.dataset.src === videos[i]) return;

            player.dataset.src = videos[i];
            player.src = videos[i];

            const playPromise = player.play();
            if (playPromise) playPromise.catch(() => { });
        }
        document.getElementById("nextBtn").onclick = () => {
            index = (index + 1) % videos.length;
            loadVideo(index);
        };
        document.getElementById("prevBtn").onclick = () => {
            index = (index - 1 + videos.length) % videos.length;
            loadVideo(index);
        };
        loadVideo(index);
        let startY = 0;

        player.addEventListener("touchstart", (e) => {
            startY = e.touches[0].clientY;
        });

        player.addEventListener("touchmove", (e) => {
            e.preventDefault();
        }, { passive: false });

        player.addEventListener("touchend", (e) => {
            let endY = e.changedTouches[0].clientY;
            let diff = startY - endY;

            if (diff > 50) {
                index = (index + 1) % videos.length;
                loadVideo(index);
            }

            if (diff < -50) {
                index = (index - 1 + videos.length) % videos.length;
                loadVideo(index);
            }
        });
    </script>

@endsection