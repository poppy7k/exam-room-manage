@props([
    'href' => '#', 
    'room' => '0',
    'floor' => '0',
    'valid_seat' => '0',
    'total_seat' => '0',
    'room_id',
    'buildingId'
])

<div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg" data-room-id="{{ $room_id }}">
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
            <p class="absolute justify-end -mx-1 -my-7 px-2 py-1 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                {{ $valid_seat }} ที่นั่ง
            </p>
        </div>
        <div class="flex justify-between pb-1 pt-3">
            <x-buttons.primary type="button" class="py-1.5 px-12 z-10 select-room-button">
                เลือก
            </x-buttons.primary>
        </div>
    </div>
</div>

<script>
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
            roomElement.innerHTML = `
                <p>${room.room} - ${room.floor} - ${room.validSeat}</p>
            `;
            selectedRoomsContainer.appendChild(roomElement);
        });
    }
});
</script>