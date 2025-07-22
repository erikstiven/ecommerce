<x-guest-layout>
    <x-authentication-card width="sm:max-w-2xl">
        <x-slot name="logo">
            <div class="flex justify-center md:justify-start">
                <a href="/">
                    <img src="/img/logo_hmbsport.png" alt="HMB Sport Logo" class="h-14 md:h-20 object-contain" />
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

                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-white/90 font-medium" />
                    <x-input id="password" class="block mt-1 w-full text-black" type="password" name="password"
                        required autocomplete="new-password" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"
                        class="text-white/90 font-medium" />
                    <x-input id="password_confirmation" class="block mt-1 w-full text-black" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
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
