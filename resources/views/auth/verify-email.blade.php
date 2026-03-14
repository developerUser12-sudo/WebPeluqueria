@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center">

        <img src="/storage/logo-sin-fondo.png" alt="Logo">
    </div>
    <div class="rounded-4 ">

        <div class="mb-4 text-sm text-light ">
            {{ __('Gracias por registrarte. Antes de continuar, por favor, verifica tu cuenta para usar todas las funciones, pinchando en el enlace que te acabamos de enviar a tu correo electrónico.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-success">
                {{ __('Te hemos enviado un nuevo enlace de verificación') }}
            </div>
        @endif

        <div class="mt-4 d-flex  justify-content-between align-items-center gap-5 ">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Reenviar correo de verificación') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="underline text-sm text-light rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Cancelar') }}
                </button>
            </form>
        </div>

    </div>
@endsection