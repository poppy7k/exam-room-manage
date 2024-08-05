<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Complied css -->
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Script -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    </head>
    <body class="flex min-h-screen bg-gray-200">
        <x-notification />
        <x-modals.confirmation />
        <x-modals.building-edit />
        <x-modals.room-edit />
        @yield('body')
    </body>
</html>