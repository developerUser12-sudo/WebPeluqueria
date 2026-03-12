@extends('layouts.app')

@section('content')
    <div class="bg-secondary d-flex justify-content-center align-items-center" style="height:85vh">
        <div class=" bg-black p-5 rounded-4 ">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <label for="name" class="text-light">Nombre</label>
                    <input id="name" class="block mt-1 w-full rounded-2" type="text" name="name" required autofocus>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <label for="surname" class="text-light">Apellidos</label>
                    <input id="surname" class="block mt-1 w-full rounded-2" type="text" name="surname" required autofocus>
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <label for="phone" class="text-light">Número de teléfono</label>
                    <input id="phone" class="block mt-1 w-full rounded-2" type="text" name="phone" required autofocus>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="email" class="text-light">Correo electrónico</label>
                    <input id="email" class="block mt-1 w-full rounded-2" type="email" name="email" :value="old('email')"
                        required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="password" class="text-light">Contraseña</label>
                    <input id="password" class="block mt-1 w-full rounded-2" type="password" name="password" required>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="text-light">Confirmar contraseña</label>
                    <input id="password_confirmation" class="block mt-1 w-full rounded-2" type="password"
                        name="password_confirmation" required>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember" required>
                        <span class="ms-2 text-light">Acepto la <a href="/politica-de-privacidad">política de privacidad</a> y el <a href="/aviso-legal">aviso legal</a></span>
                    </label>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <a class=" text-sm text-light " href="{{ route('login') }}">
                        {{ __('¿Ya estás registrado?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection