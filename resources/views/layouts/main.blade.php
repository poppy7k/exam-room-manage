@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    <!-- Pop-up -->
    <div id="popup">
        @include('components.modals.building-edit')
        @include('components.modals.room-edit')
        @include('components.modals.examiner-select')
        @include('components.modals.exam-edit')
    </div>
    <div id="modal">
        @include('components.modals.applicant-modal')
    </div>
    @include('layouts.navbar')
    <main class="flex flex-grow h-full">
        @include('layouts.sidebar')
        <div id="content" class="flex flex-col z-20 container mt-24 lg:pr-1 pr-10 pl-10 mb-8 w-screen transition-all ease-in-out duration-500 lg:translate-x-28">
            @yield('content')
        </div>
    </main>
</div>
@endsection