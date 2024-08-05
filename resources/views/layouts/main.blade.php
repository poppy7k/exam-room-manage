@extends('layouts.base')

@section('body')
<div class="flex flex-col min-h-screen">
    <!-- Pop-up -->
    <div id="modal">
        <div id="room">
            <x-modals.room-edit />
        </div>
        <div id="applicant"> 
            <x-modals.applicant-modal />
            <x-modals.applicant-update />
            <x-modals.applicant-delete />
        </div>
        <div id="exam">
            <x-modals.exam-status />
            <x-modals.exam-edit />
        </div>
        <x-modals.confirmation />
        <x-modals.building-edit />
        <x-modals.examiner-select />
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