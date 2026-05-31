@extends('layouts.app')
@section('card-style', 'width:500px')

@section('content')
<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
        <x-input-label class="text-light" for="email" :value="__('Correo electrónico')" />
        <x-text-input  id="email" class="block mt-1 w-full text-dark" type="email" name="email"  required />
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-end" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label class="text-light" for="password" :value="__('Contraseña')" />
        <x-text-input id="password" class="block mt-1 w-full text-dark" type="password" name="password" required
            autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-end" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label class="text-light" for="password_confirmation" :value="__('Confirmar contraseña')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full text-dark" type="password" name="password_confirmation"
            required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Restablecer contraseña') }}
        </x-primary-button>
    </div>
</form>
@endsection