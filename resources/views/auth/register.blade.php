<x-guest-layout>
    <x-authentication-card width="sm:max-w-2xl">
        <x-slot name="logo">
            <div class="flex justify-center md:justify-start">
                <a href="/">
                    <img src="/img/logo.png" alt="HMB Sport Logo" class="h-14 md:h-20 object-contain" />
                </a>
            </div>
        </x-slot>

        <x-validation-user-errors class="alert-error mb-4" />


        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-2  gap-4">
                {{-- Nombre --}}
                <div>
                    <x-label for="name" value="{{ __('Name') }}" class="text-white/90 font-medium" />
                    <x-input id="name" class="block mt-1 w-full text-black" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                </div>
                {{-- Apellidos --}}
                <div>
                    <x-label for="last_name" value="Apellidos" class="text-white/90 font-medium" />
                    <x-input id="last_name" class="block mt-1 w-full text-black" type="text" name="last_name"
                        :value="old('last_name')" required autocomplete="last_name" />
                </div>
                {{-- Tipo de Documento --}}
                <div>
                    <x-label for="document_type" value="Tipo de Documento" class="text-white/90 font-medium" />
                    <x-select class="w-full text-black" id="document_type" name="document_type">
                        <option value="" disabled selected>Seleccione una opción</option>

                        @foreach (App\Enums\TypeOfDocuments::cases() as $item)
                            <option value="{{ $item->value }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
                {{-- Dcoumento --}}
                <div>
                    <x-label for="document_number" value="Documento" class="text-white/90 font-medium" />
                    <x-input id="document_number" class="block mt-1 w-full text-black" name="document_number"
                        :value="old('document_number')" required />

                </div>
                {{-- Email --}}

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-white/90 font-medium" />
                    <x-input id="email" class="block mt-1 w-full text-black" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                </div>
                {{-- Telefono --}}
                <div>
                    <x-label for="phone" value="Teléfono" class="text-white/90 font-medium" />
                    <x-input id="phone" class="block mt-1 w-full text-black" name="phone" :value="old('phone')"
                        required />
                </div>

                {{-- <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-white/90 font-medium" />
                    <x-input id="password" class="block mt-1 w-full text-black" type="password" name="password"
                        required autocomplete="new-password" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"
                        class="text-white/90 font-medium" />
                    <x-input id="password_confirmation" class="block mt-1 w-full text-black" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div> --}}

                {{-- Contraseña --}}
                <div class="relative">
                    <x-label for="password" value="{{ __('Password') }}" class="text-white/90 font-medium" />
                    <div class="relative">
                        <x-input id="password" class="block mt-1 w-full text-black pr-10" type="password"
                            name="password" required autocomplete="new-password" />
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-300">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 3.93 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zm0 10a3 3 0 110-6 3 3 0 010 6z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="relative">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"
                        class="text-white/90 font-medium" />
                    <div class="relative">
                        <x-input id="password_confirmation" class="block mt-1 w-full text-black pr-10" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <button type="button" id="toggleConfirmPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 dark:text-gray-300">
                            <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 3.93 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zm0 10a3 3 0 110-6 3 3 0 010 6z" />
                            </svg>
                        </button>
                    </div>
                </div>


            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div>
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-white dark:text-gray-400 hover:text-blue-500 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4 btn-login-f">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Función reutilizable
    function togglePassword(buttonId, inputId, iconId) {
        const button = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (!button || !input || !icon) return; // Seguridad por si no existen

        button.addEventListener('click', function () {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            // Cambiar el ícono (ojo abierto/cerrado)
            icon.innerHTML = type === 'text'
                ? '<path d="M4.03 3.97a.75.75 0 011.06 0L16.03 14.9a.75.75 0 11-1.06 1.06l-1.41-1.41A8.956 8.956 0 0110 17c-5 0-8.27-4.11-8.93-7 .39-1.7 1.3-3.38 2.74-4.77L4.03 3.97z" />'
                : '<path d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 3.93 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zm0 10a3 3 0 110-6 3 3 0 010 6z" />';
        });
    }

    // Aplicar a ambos campos
    togglePassword('togglePassword', 'password', 'eyeIcon');
    togglePassword('toggleConfirmPassword', 'password_confirmation', 'eyeIconConfirm');
});
</script>
