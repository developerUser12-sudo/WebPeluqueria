@extends('layouts.app')
@section('card-style', 'width:600px')

@section('content')
    <div class="mb-4 text-sm text-light">
        {{ __('¿Has olvidado tu contraseña? No hay problema. Introduce tu correo electrónico y te enviaremos un enlace para crear una nueva contraseña.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label class="text-light" for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full text-black" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

@endsection