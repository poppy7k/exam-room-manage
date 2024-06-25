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
        @yield('body')
        @if (session('status') === 'success')
        <div class="absolute flex w-screen justify-center">
            <div
                x-cloak
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-50 -translate-y-60 scale-75"
                x-init="() => { setTimeout(() => show = true, 100); setTimeout(() => show = false, 2100); }"
                class="flex items-center justify-between fixed rounded-lg top-0 transform w-max z-20 bg-green-200 border-2 border-green-500 my-[84px] px-5 py-3 text-green-700"
            >
                {{ session('message') }}
                <button @click="show = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-10" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
        @elseif (session('status') === 'failed')
        <div class="absolute flex w-screen justify-center">
            <div
                x-cloak
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-50 -translate-y-60 scale-75"
                x-init="() => { setTimeout(() => show = true, 100); setTimeout(() => show = false, 2100); }"
                class="flex items-center justify-between fixed rounded-lg top-0 transform w-max z-20 bg-red-200/90 border-2 border-red-500 my-[84px] px-5 py-3 text-red-700"
            >
                {{ session('message') }}
                <button @click="show = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-10" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
        @endif
    </body>
</html>