@props([
    'href' => '#', 
    'room' => '0',
    'floor' => '0',
    'valid_seat' => '0',
    'total_seat' => '0',
    'exam_valid_seat' => '0',
    'room_id',
    'buildingId'
])

<div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg" data-room-id="{{ $room_id }}">
    @if ($valid_seat > 0 )
    <a class="select-room-button absolute inset-0 z-0 cursor-pointer"></a>
    @endif
    <div class="hidden select-room-button room-checked absolute flex flex-col gap-2 justify-center items-center inset-0 z-40 bg-green-300/90 rounded-lg cursor-pointer transition-all duration-100 group hover:bg-red-300/90">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 group-hover:hidden block fill-green-800" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 507.506 507.506" style="enable-background:new 0 0 507.506 507.506;" xml:space="preserve" width="512" height="512"><g><path d="M163.865,436.934c-14.406,0.006-28.222-5.72-38.4-15.915L9.369,304.966c-12.492-12.496-12.492-32.752,0-45.248l0,0   c12.496-12.492,32.752-12.492,45.248,0l109.248,109.248L452.889,79.942c12.496-12.492,32.752-12.492,45.248,0l0,0   c12.492,12.496,12.492,32.752,0,45.248L202.265,421.019C192.087,431.214,178.271,436.94,163.865,436.934z"/></g></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 hidden group-hover:block fill-red-800" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512"><g><path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387   c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/></g></svg>
        <p class="text-green-800 font-semibold text-xl block group-hover:hidden">
            ได้เลือกห้องนี้แล้ว
        </p>
        <p class="text-red-800 font-semibold text-xl hidden group-hover:block fill-red-800">
            ยกเลิกห้องนี้
        </p>
    </div>
    <div class="px-4 py-3 text-surface text-black">
        <div class="group flex">
            <span class="relative group flex hover-trigger">
                <p class="text-2xl -my-1 font-semibold max-w-28 truncate">
                    {{ $room }}
                </p>
                <p class="text-gray-600 -my-1 pl-2 py-1.5">
                    ชั้น {{ $floor }}
                </p>
                <x-tooltip title="{{ $room }} ชั้น {{ $floor }}" class="group-hover:-translate-x-20 group-hover:translate-y-4 z-20"></x-tooltip>
            </span> 
        </div>
        <div class="flex justify-end">
            @if ($valid_seat > 0 )
            <p class="absolute justify-end -mx-1 -my-7 px-2 py-1 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                {{ $valid_seat }} ที่นั่ง
            </p>
            @else
            <p class="absolute justify-end -mx-1 -my-7 px-2 py-1 bg-gradient-to-tr from-red-600 to-red-400 rounded-lg text-sm text-white shadow-md">
                ไม่ว่าง
            </p>
            @endif
        </div>
        <div class="flex justify-between pb-1 pt-3">
            @if ($valid_seat > 0 )
            <x-buttons.primary type="button" class="py-1.5 px-12 z-10 select-room-button">
                เลือก
            </x-buttons.primary>
            @else
            <x-buttons.danger type="button" class="py-1.5 px-12 z-10">
                ไม่สามารถเลือกได้
            </x-buttons.danger>
            @endif
        </div>
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
                room.validSeat = Math.min(room.validSeat, requiredSeats);
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