@props([
    'href' => '#', 
    'room' => '0',
    'floor' => '0',
    'valid_seat' => '0',
    'total_seat' => '0',
    'room_id',
    'buildingId'
])

<div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg"">
    <a href="{{ $href }}" class="absolute inset-0 z-0"></a>
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
            <x-buttons.primary type="button" class="py-1.5 z-10"
                onclick="window.location.href = '{{ route('room-detail', ['buildingId' => $buildingId, 'roomId' => $room_id]) }}'">
                เลือก
            </x-buttons.primary>
            <x-buttons.icon-info type="button" onclick="event.stopPropagation(); openRoomEditModal('{{ $room }}', '{{ $floor }}', '{{ $room_id }}')" class="px-1 py-1 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20">
                    <path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/>
                </svg>
                <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
            </x-buttons.icon-info>
            <x-buttons.icon-danger type="button" onclick="event.stopPropagation(); deleteRoom('{{ $room_id }}')" class="px-1 py-1 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                <x-tooltip title="ลบห้องสอบ" class="group-hover:-translate-x-6"></x-tooltip>
            </x-buttons.icon-danger>
        </div>
    </div>
</div>

<script>
function deleteRoom(roomId) {
        if (confirm('Are you sure you want to delete this room?')) {
            fetch(`/examrooms/${roomId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Room deleted successfully.');
                    location.reload();
                } else {
                    alert('Failed to delete the room.');
                }
            });
        }
    }
</script>
