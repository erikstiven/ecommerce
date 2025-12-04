<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-user-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-white/90 font-medium" />
                <x-input id="email" class="block mt-1 w-full text-black" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Password') }}" class="text-white/90 font-medium" />

                <div class="relative">
                    <x-input id="password" class="block mt-1 w-full text-black pr-10" type="password" name="password"
                        required autocomplete="current-password" />

                    <!-- Botón para mostrar/ocultar -->
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-300">
                        <!-- Ícono de ojo -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 3.93 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zm0 10a3 3 0 110-6 3 3 0 010 6z" />
                        </svg>
                    </button>
                </div>
            </div>


            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-white dark:text-gray-400">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white dark:text-gray-400 hover:text-blue-500 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-button class="ms-4 btn-login-f">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambiar icono
            if (type === 'text') {
                eyeIcon.setAttribute('d',
                    'M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 3.93 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zm0 10a3 3 0 110-6 3 3 0 010 6z'
                    );
            } else {
                eyeIcon.setAttribute('d',
                    'M4.03 3.97a.75.75 0 011.06 0L16.03 14.9a.75.75 0 11-1.06 1.06l-1.41-1.41A8.956 8.956 0 0110 17c-5 0-8.27-4.11-8.93-7 .39-1.7 1.3-3.38 2.74-4.77L4.03 3.97z'
                    );
            }
        });
    });
</script>
