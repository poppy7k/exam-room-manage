@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    @include('layouts.navbar')
    <main class="flex flex-grow">
        @include('layouts.sidebar')
        <div id="content" class="flex flex-col z-20 container mt-24 ml-8 mb-24 lg:ml-80 w-full transition-transform duration-500">
            @yield('content')
        </div>
    </main>
</div>
@endsection