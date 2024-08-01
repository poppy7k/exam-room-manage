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
    <a href="{{ route('pages.calendar.list') }}">
        <div class ="bg-white text-2xl px-16 py-32 font-bold w-max rounded-lg shadow-md transition-all duration-500 hover:scale-110">
            ปฏิทินการสอบ
        </div>
    </a>
</div> 
@endsection()

<!-- 
เลือกห้องสอบแบบหลายๆตึกได้
การจัดคนใส่ห้องสอบสามารถเลือกการใส่ได้แบบ แนวตั้งหรือแนวนอน