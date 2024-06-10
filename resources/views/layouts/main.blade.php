@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    @include('layouts.navbar')
    <main class="flex flex-grow h-full">
        @include('layouts.sidebar')
        <div id="content" class="flex flex-col z-20 container mt-24 pl-52 mb-24 w-screen transition-all ease-in-out duration-500 translate-x-28">
            @yield('content')
        </div>
    </main>
</div>
@endsection