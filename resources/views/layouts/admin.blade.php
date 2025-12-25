@props(['breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

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
    <script src="https://unpkg.com/lucide@latest"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased h-full"
    x-data="{ sidebarOpen: false, sidebarCollapsed: true }">

    <div class="h-screen bg-gray-50 flex">
        {{-- Sidebar en flujo (no fixed/absolute) --}}
        @include('layouts.partials.admin.sidebar')

        <main class="flex-1 min-w-0 p-4 overflow-y-auto">
            <div class="flex justify-between items-center">
                @include('layouts.partials.admin.breadcrumb')

                @isset($action)
                    <div>{{ $action }}</div>
                @endisset
            </div>

            <div class="mt-4 p-4 border-2 border-gray-200 border-dashed rounded-lg">
                {{ $slot }}
            </div>
        </main>
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
// Ejecutar al cargar la página (categorías, dashboard, etc.)
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) {
        lucide.createIcons();
    }
});

document.addEventListener('livewire:init', () => {
            Livewire.hook('message.processed', () => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
});

</script>



</body>
</html>
