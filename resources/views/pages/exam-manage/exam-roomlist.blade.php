@extends('layouts.main')

@section('content')

<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">
                รายการห้องสอบ
            </p>
            <p class="font-normal text-md px-3 mt-1.5">
                -
            </p>
            <p class="font-normal text-md mt-1.5">
                ทั้งหมด {{ $totalRoom }}
            </p>
        </div> 
        <div class="flex">
            <div x-data="{ showFilterExamRoom: false }" class="z-40"> 
                <x-buttons.icon-primary @click="showFilterExamRoom = !showFilterExamRoom" id="filter-building" onclick="event.stopPropagation();" class="px-[5px] pt-1.5 pb-1 z-40 from-white to-white">
                    <svg id="Layer_1" class="w-5 h-5" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m14 24a1 1 0 0 1 -.6-.2l-4-3a1 1 0 0 1 -.4-.8v-5.62l-7.016-7.893a3.9 3.9 0 0 1 2.916-6.487h14.2a3.9 3.9 0 0 1 2.913 6.488l-7.013 7.892v8.62a1 1 0 0 1 -1 1zm-3-4.5 2 1.5v-7a1 1 0 0 1 .253-.664l7.268-8.177a1.9 1.9 0 0 0 -1.421-3.159h-14.2a1.9 1.9 0 0 0 -1.421 3.158l7.269 8.178a1 1 0 0 1 .252.664z"/></svg>
                    <x-tooltip title="ฟิลเตอร์อาคารสอบ" class="group-hover:-translate-x-11"></x-tooltip>
                </x-buttons.icon-primary>
                <x-dropdowns.exam-room-list.filter :examId="$exams->id" :buildingId="$buildings->id" />
            </div>
            <div class="search-container px-2">
                <input type="text" id="search-input" placeholder="ค้นหาห้องสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
        </div>
    </div>
    @if(session('status') == 'conflict')
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <p>พบปัญหาการจองห้องสำหรับผู้เข้าสอบต่อไปนี้:</p>
            <ul>
                @foreach(session('conflictedApplicants') as $conflictedApplicant)
                    <li>{{ $conflictedApplicant }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
        @forelse($rooms as $room)
            <x-exam-room-card
                :room="$room->room"
                :floor="$room->floor"
                :valid_seat="$room->valid_seat"
                :total_seat="$room->total_seat"
                :exam_valid_seat="$room->exam_valid_seat ?? 0"      
                :room_id="$room->id"
                :buildingId="$room->building_code"
            />
        @empty
            <div class="col-span-4 text-center py-32 my-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mt-10 mb-5 fill-gray-500" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
                    <g>
                        <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387   c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
                    </g>
                </svg>        
                <p class="pb-2 text-center text-gray-500">
                    ไม่พบห้องสอบ
                </p>
            </div>
        @endforelse
    </div>
    <div class="mt-4 col-span-4 mx-auto">
        {{ $rooms->links('pagination::bootstrap-4') }}
    </div>
</div>

<div class="flex items-center justify-center fixed rounded-lg bottom-0 transform w-10/12 z-20 ">
    <div class="flex gap-3 bg-white rounded-lg border-1 border-gray-50 my-8 text-black shadow-xl">
        <p class="px-5 py-3 my-auto">
            ห้องที่เลือก
        </p>
        <p id="selected-rooms" class="flex gap-1 min-w-60 max-w-60 font-semibold text-green-700 py-3 my-auto"></p>
        <div class="py-3 my-auto flex gap-2">
            จำนวนที่นั่ง
            <p id="selected-seats" class="ml-5 text-green-700 font-semibold">
                0
            </p>
            <p>
                /
            </p>
            <p id="applicant-quantity">
                {{ $exams->exam_takers_quantity }}
            </p>
        </div>
        <form class="my-auto mx-5" id="submit-form" method="POST" action="{{ route('update-exam-status') }}">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exams->id }}">
            <input type="hidden" name="selected_rooms" id="selected-rooms-input">
            <x-buttons.primary type="submit" class="px-5 py-auto">
                ยืนยัน
            </x-buttons.primary>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectedRooms = [];

    document.querySelectorAll('.select-room-button').forEach(button => {
        button.addEventListener('click', function () {
            const roomItem = this.closest('.room-item');
            const roomChecked = roomItem.querySelector('.room-checked');
            const roomId = roomItem.getAttribute('data-room-id');
            const roomDetails = {
                id: roomId,
                room: roomItem.querySelector('p.text-2xl').innerText,
                floor: roomItem.querySelector('p.text-gray-600').innerText,
                validSeat: parseInt(roomItem.querySelector('p.absolute').innerText),
            };

            if (!selectedRooms.some(room => room.id === roomId)) {
                selectedRooms.push(roomDetails);
                updateSelectedRoomsList();
                roomChecked.classList.remove('hidden');
            } else {
                selectedRooms.splice(selectedRooms.findIndex(room => room.id === roomId), 1);
                updateSelectedRoomsList();
                roomChecked.classList.add('hidden');
            }
        });
    });

    function updateSelectedRoomsList() {
        const selectedRoomsContainer = document.getElementById('selected-rooms');
        const selectedSeatsContainer = document.getElementById('selected-seats');
        selectedRoomsContainer.innerText = '';
        selectedSeatsContainer.innerText = '0';

        selectedRooms.forEach(room => {
            const roomText = document.createTextNode(`${room.room}, `);
            selectedRoomsContainer.appendChild(roomText);
        });
        selectedSeatsContainer.innerText = getTotalValidSeat();
        document.getElementById('selected-rooms-input').value = JSON.stringify(selectedRooms);
    }

    function getTotalValidSeat() {
        return selectedRooms.reduce((total, room) => total + room.validSeat, 0);
    }

    document.getElementById('submit-form').addEventListener('submit', function (event) {
        const selectedSeats = parseInt(document.getElementById('selected-seats').innerText);
        const requiredSeats = parseInt(document.getElementById('applicant-quantity').innerText);

        selectedRooms.forEach(room => {
            room.validSeat = room.validSeat;
            room.usedSeat = Math.min(room.validSeat, requiredSeats);
        });

        if (selectedSeats < requiredSeats) {
            event.preventDefault();
            alert('จำนวนที่นั่งไม่เพียงพอสำหรับผู้เข้าสอบ');
        } else {
            document.getElementById('selected-rooms-input').value = JSON.stringify(selectedRooms);
        }
    });
});



</script>

@endsection
