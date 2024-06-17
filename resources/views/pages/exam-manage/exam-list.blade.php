@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">
                การสอบทั้งหมด
            </p>
            <p class="font-normal text-md px-3 mt-1.5">
                -
            </p>
            <p class="font-normal text-md mt-1.5">
                ทั้งหมด
            </p>
        </div> 
        <div class="flex">
            <div class="search-container px-2">
                <input type="text" id="search-input" placeholder="ค้นหาการสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
            <x-buttons.icon-primary type="submit" onclick="window.location.href = '{{ route('exam-create') }}'" class="px-1.5 py-1 z-40">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16" height="16"><g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192   c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>/</svg>
                <x-tooltip title="สร้างการสอบ" class="group-hover:-translate-x-9"></x-tooltip>
            </x-buttons.icon-primary>
        </div>
    </div>
    {{-- <div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg"">
        <a href="#" class="absolute inset-0 z-0"></a>
        <div class="px-4 py-3 text-surface text-black">
            <div class="group flex">
                <span class="relative group flex hover-trigger">
                    <p class="text-xl my-1 font-semibold w-56 truncate">
                        ทดสอบทดสอบทดสอบทดสอบทดสอบ
                    </p>
                    <x-tooltip title="ทดสอบทดสอบทดสอบทดสอบทดสอบ" class="group-hover:-translate-x-20 group-hover:translate-y-4 z-20"></x-tooltip>
                </span> 
            </div>
            <div class="my-2 flex">
                สถานะ: 
                <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-yellow-600 to-yellow-400 rounded-lg text-sm text-white shadow-md">
                    เลือกห้อง
                </p>
            </div>
            <div class="flex">
                เวลาสอบ: 13.00 - 16.00
            </div>
            <div class="flex">
                ตำแหน่ง: คณิตศาสตร์
            </div>
            <div class="mb-2 mt-4 flex">
                จัดสอบโดย: สำนักคอม
            </div>
            <div class="flex justify-between pb-1 pt-3">
                <x-buttons.primary type="button" class="py-1.5 px-12 z-10"
                    onclick="">
                    เลือก
                </x-buttons.primary>
                <x-buttons.icon-info type="button" onclick="" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20">
                        <path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/>
                    </svg>
                    <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
                </x-buttons.icon-info>
                <x-buttons.icon-danger type="button" onclick="" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                    <x-tooltip title="ลบห้องสอบ" class="group-hover:-translate-x-6"></x-tooltip>
                </x-buttons.icon-danger>
            </div>
        </div>
    </div> --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
        @forelse($exams as $exam)
            <x-exam-card
                :department_name="$exam->department_name"
                :exam_position="$exam->exam_position"
                :exam_date="$exam->exam_date"
                :exam_start_time="$exam->exam_start_time"      
                :exam_end_time="$exam->exam_end_time"

            />
        @empty

        @endforelse
    </div>
    <div id="empty-state" class="col-span-4 text-center py-32 my-3" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mt-10 mb-5 fill-gray-500" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
            <g>
                <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387   c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
            </g>
        </svg>        
        <p class ="pb-2 text-center text-gray-500">
            ไม่พบอาคารสอบ
        </p>
    </div>
</div>

@endsection