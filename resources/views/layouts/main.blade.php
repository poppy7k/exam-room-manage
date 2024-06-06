@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    @include('layouts.navbar')
    <main class="flex flex-col-5">
        @include('layouts.sidebar')
        @yield('content')
    </main>
</div>
@endsection