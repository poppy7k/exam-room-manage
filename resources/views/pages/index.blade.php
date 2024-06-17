@extends('layouts.main')

@section('content')
<div class="w-full px-16 py-10 my-3 flex gap-24 justify-center items-center">
    <a href="{{ route('building-list') }}">
        <div class="bg-white text-2xl px-16 py-32 font-bold w-max rounded-lg shadow-md transition-all duration-500 hover:scale-110">
            จัดการห้องสอบ
        </div>
    </a>
    <a href="{{ route('exam-list') }}">
        <div class ="bg-white text-2xl px-16 py-32 font-bold w-max rounded-lg shadow-md transition-all duration-500 hover:scale-110">
            จัดการการสอบ
        </div>
    </a>
</div>
@endsection()