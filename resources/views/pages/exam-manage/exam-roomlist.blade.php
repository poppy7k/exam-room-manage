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
                    ทั้งหมด {{ count($rooms) }}
                </p>
            </div> 
            <div class="flex">
                <div class="search-container px-2">
                    <input type="text" id="search-input" placeholder="ค้นหาห้องสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
            @forelse($rooms as $room)
                <x-exam-room-card
                    :room="$room->room"
                    :floor="$room->floor"
                    :valid_seat="$room->valid_seat"
                    :total_seat="$room->total_seat"      
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
        <div class="flex gap-3 bg-white rounded-lg border-1 border-gray-50 my-[84px] text-black shadow-xl">
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
                    0
                </p>
            </div>
            <x-buttons.primary class="px-5 py-auto my-auto mx-5">
                ยืนยัน
            </x-buttons.primary>
            <form id="submit-form" method="POST" action="{{ route('update-exam-status') }}">
                @csrf
                <input type="hidden" name="exam_id" value="{{ $exams->id }}">
                <input type="hidden" name="selected_rooms" id="selected-rooms-input">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function showSelectedRoomsPopup() {
            document.getElementById('selected-rooms-popup').classList.remove('hidden');
        }
    
        function closeSelectedRoomsPopup() {
            document.getElementById('selected-rooms-popup').classList.add('hidden');
        }
    
        document.getElementById('search-input').addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var roomItems = document.getElementsByClassName('room-item');
            var hasVisibleItems = false;
    
            Array.from(roomItems).forEach(function(item) {
                var roomName = item.textContent.toLowerCase();
                if (roomName.includes(searchQuery)) {
                    item.style.display = 'block';
                    hasVisibleItems = true;
                } else {
                    item.style.display = 'none';
                }
            });
            document.getElementById('empty-state').style.display = hasVisibleItems ? 'none' : 'block';
        });
    
        document.addEventListener('DOMContentLoaded', function () {
            const selectedRooms = [];
    
            document.querySelectorAll('.select-room-button').forEach(button => {
                button.addEventListener('click', function () {
                    const roomItem = this.closest('.room-item');
                    const roomId = roomItem.getAttribute('data-room-id');
                    const roomDetails = {
                        id: roomId,
                        room: roomItem.querySelector('p.text-2xl').innerText,
                        floor: roomItem.querySelector('p.text-gray-600').innerText,
                        validSeat: roomItem.querySelector('p.absolute').innerText,
                    };
    
                    if (!selectedRooms.some(room => room.id === roomId)) {
                        selectedRooms.push(roomDetails);
                        updateSelectedRoomsList();
                    }
                });
            });
    
            function updateSelectedRoomsList() {
                const selectedRoomsContainer = document.getElementById('selected-rooms');
                selectedRoomsContainer.innerHTML = '';
    
                selectedRooms.forEach(room => {
                    const roomElement = document.createElement('div');
                    roomElement.className = 'selected-room';
                    roomElement.innerHTML = `<p>${room.room} - ${room.floor} - ${room.validSeat}</p>`;
                    selectedRoomsContainer.appendChild(roomElement);
                });
    
                // Update hidden input with selected rooms
                document.getElementById('selected-rooms-input').value = JSON.stringify(selectedRooms);
            }
        });
    </script>
@endsection
