@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class="bg-black p-5 rounded-4 ">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="text-light">Correo electrónico</label>
                    <input id="email" class="block mt-1 w-full rounded-2" type="email" name="email" :value="old('email')" required
                        autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="password" class="text-light">Contraseña</label>
                    <input id="password" class="block mt-1 w-full rounded-2" type="password" name="password" required>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-light">{{ __('Recuérdame') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class=" text-sm text-light"
                            href="{{ route('password.request') }}">
                            {{ __('¿Contraseña olvidada?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Iniciar sesión') }}
                    </x-primary-button>
                </div>
                <div class="mt-3">
                    <a class="text-sm text-light"
                            href="{{ route('register') }}">
                            {{ __('¿No tienes cuenta? Regístrate') }}
                        </a>
                </div>
            </form>
        </div>
    </div>
@endsection