@props(['breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('', 'Ecommerce-Codecima') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.png') }}?v={{ time() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Iconos -->
    <script src="https://kit.fontawesome.com/624f2e432c.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">

    {{-- Overlay responsive --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 sm:hidden"
        x-show="sidebarOpen"
        x-on:click="sidebarOpen = false">
    </div>

    @include('layouts.partials.admin.navegation')
    @include('layouts.partials.admin.sidebar')

    <div class="p-4 sm:ml-64">
        <div class="mt-14">

            <div class="flex justify-between items-center">
                @include('layouts.partials.admin.breadcrumb')

                @isset($action)
                    <div>{{ $action }}</div>
                @endisset
            </div>

            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                {{ $slot }}
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts

    @stack('js')

    {{-- SweetAlert desde Livewire --}}
    <script>
        Livewire.on('swal', data => {
            Swal.fire(data[0]);
        });
    </script>

    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.hook('message.processed', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    });

    // Ejecutar la primera vez
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
    </script>


</body>
</html>
