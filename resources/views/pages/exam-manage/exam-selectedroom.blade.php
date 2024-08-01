@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">รายการห้องสอบ</p>
            <p class="font-normal text-md px-3 mt-1.5">-</p>
            <p class="font-normal text-md mt-1.5">ทั้งหมด {{ count($selectedRooms) }}</p>
        </div> 
        <div class="flex gap-1">
            <x-buttons.primary type="button" class="px-5 py-2 rounded-lg text-white"
                onclick="window.location.href = '{{ route('exam-buildinglist', ['examId' => $exams->id]) }}'">
                เลือกห้องใหม่
            </x-buttons.primary>
            <div x-data="{ showFilterExamSelectedRoom: false }" class="z-40"> 
                <x-buttons.icon-primary @click="showFilterExamSelectedRoom = !showFilterExamSelectedRoom" id="filter-exam-selected-room" onclick="event.stopPropagation();" class="px-[5px] pt-1.5 pb-1 z-40">
                    <svg id="Layer_1" class="w-5 h-5" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m14 24a1 1 0 0 1 -.6-.2l-4-3a1 1 0 0 1 -.4-.8v-5.62l-7.016-7.893a3.9 3.9 0 0 1 2.916-6.487h14.2a3.9 3.9 0 0 1 2.913 6.488l-7.013 7.892v8.62a1 1 0 0 1 -1 1zm-3-4.5 2 1.5v-7a1 1 0 0 1 .253-.664l7.268-8.177a1.9 1.9 0 0 0 -1.421-3.159h-14.2a1.9 1.9 0 0 0 -1.421 3.158l7.269 8.178a1 1 0 0 1 .252.664z"/></svg>
                    <x-tooltip title="ฟิลเตอร์อาคารสอบ" class="group-hover:-translate-x-11"></x-tooltip>
                </x-buttons.icon-primary>
                <x-dropdowns.exam-selected-room.filter :examId="$exams->id"/>
            </div>
            <div class="search-container px-2">
                <input type="text" id="search-input" placeholder="ค้นหาห้องสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
        @forelse($selectedRooms as $selectedRoom)
            @if($selectedRoom->room)
                <x-exam-selectedroom-card
                    :room="$selectedRoom->room->room"
                    :floor="$selectedRoom->room->floor"
                    :valid_seat="$selectedRoom->room->valid_seat"
                    :total_seat="$selectedRoom->room->total_seat"      
                    :selected_room_applicant_quantity="$selectedRoom->applicant_seat_quantity"
                    :selected_room_id="$selectedRoom->id"
                    :building_name="$selectedRoom->room->building->building_th"
                    :exam_id="$exams->id"
                    :selectedroom_valid_seat="$selectedRoom->selectedroom_valid_seat"
                    :recent_change="$selectedRoom->recent_change"
                />
            @endif
        @empty
            <div class="col-span-4 text-center py-32 my-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mt-10 mb-5 fill-gray-500" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
                    <g>
                        <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
                    </g>
                </svg>        
                <p class="pb-2 text-center text-gray-500">ไม่พบห้องสอบ</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.getElementById('search-input').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var roomItems = document.getElementsByClassName('room-item');
        var hasVisibleItems = false;

        Array.from(roomItems).forEach(function(item) {
            var roomName = item.textContent.toLowerCase();
            if (roomName.includes(searchQuery)) {
                item.style.display = 'block';
                hasVisibleItems = true
            } else {
                item.style.display = 'none';
            }
        });
        document.getElementById('empty-state').style.display = hasVisibleItems ? 'none' : 'block';
    });
</script>
@endsection

