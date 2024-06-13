@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-y-2 divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">
                ชื่อห้อง
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                ชั้น
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                จำนวนที่นั่ง
            </p>
        </div> 
        <div class="flex">
            <p class="font-semibold text-2xl justify-start ml-4">
                แถว
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                คอลัมน์
            </p>
        </div>
    </div>
    <div class="bg-white shadow-lg px-10 py-10 my-3 border-1 rounded-lg">
        <div id="seat-container" class="grid h-screen overflow-x-scroll overflow-y-scroll"></div>
    </div>
</div>
@endsection