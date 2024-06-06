@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    @include('layouts.navbar')
    <main class="flex flex-grow">
        @include('layouts.sidebar')
        @yield('content')
    </main>
</div>
@endsection