@extends('layouts.main')

@section('content')
        <div class="flex flex-col divide-y-2 divide-gray-300 w-full">
            <div class="flex justify-between items-center">
                <div class="flex"> 
                    <p class="font-semibold text-2xl justify-start">
                        รายการห้องสอบ
                    </p>
                    <p class="font-normal text-md px-3 mt-1.5">
                        -
                    </p>
                    <p class="font-normal text-md mt-1.5">
                        ทั้งหมด {{ count($rooms) }}
                    </p>
                </div> 
                <div class="flex">
                    <div class="search-container px-2">
                        <input type="text" id="search-input" placeholder="ค้นหาห้องสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                    </div>
                    <x-buttons.icon-primary type="submit" onclick="window.location.href = '{{ route('pages.building-create') }}'" class="px-1.5 py-1 z-40">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16" height="16"><g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192   c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>/</svg>
                        <x-tooltip title="สร้างห้องสอบ" class="group-hover:-translate-x-12"></x-tooltip>
                    </x-buttons.icon-primary>
                </div>
            </div>

        <div class="grid 2xl:grid-cols-4 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-2">
            @forelse($rooms as $room)
                <x-room-card
                    :room="$room->room"
                    :floor="$room->floor"
                    :valid_seat="$room->valid_seat"
                    :total_seat="$room->total_seat"       
                />
            @empty
                <div class="col-span-4 text-center">
                    <x-buttons.icon-primary type="submit" onclick="window.location.href = '{{ route('pages.building-create') }}'" class="px-1 py-1 z-40">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16" height="16"><g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192   c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>/</svg>
                        <x-tooltip title="สร้างอาคารสอบ" class="group-hover:-translate-x-12"></x-tooltip>
                    </x-buttons.icon-primary>
                </div>
            @endforelse
            <div id="empty-state" class="flex mt-2" style="display: none;">
                <p class="justify-center">No buildings available.</p>
            </div>
        </div>
    </div>
@endsection