@extends('layouts.app')

@section('content')

    <h3 class="text-light mb-5">Login de administrador</h3>
    <form method="POST" action="{{ route('admin.loginadmin.submit') }}">
        @csrf
        <div>
            <label for="email" class="text-light">Correo electrónico</label>
            <input id="email" class="block mt-1 w-full rounded-2 text-black" type="email" name="email" :value="old('email')" required
                autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="text-light">Contraseña</label>
            <input id="password" class="block mt-1 w-full rounded-2 text-black" type="password" name="password" required>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-3">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>

    </form>

@endsection