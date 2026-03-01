@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 " style="width:450px">

            @csrf
            <livewire:reserva-form />



        </div>
    </div>
    <script>
        document.getElementById("servicio").addEventListener('change', function () {
            const texto = this.options[this.selectedIndex].dataset.info;
            document.getElementById('detalles').textContent = texto;
        })
    </script>
@endsection