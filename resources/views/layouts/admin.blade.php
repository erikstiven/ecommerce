<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!--iconos importados awesome google-->
    <script src="https://kit.fontawesome.com/624f2e432c.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: false }" :class="{
    'overflow-y-hidden': sidebarOpen,
}">
    //parte negra en modo responsive
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 sm:hidden" style="display: none" x-show="sidebarOpen"
        x-on:click="sidebarOpen = false">

    </div>

    //llamamos al componente de navegacion
    @include('layouts.partials.admin.navegation')
    //llamamos al componente de slidebar
    @include('layouts.partials.admin.sidebar')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            //defino el slot para que se muestre el contenido de las vistas
            {{ $slot }}
        </div>
    </div>

    @livewireScripts


    <script>
    lucide.createIcons();
</script>

</body>

</html>
