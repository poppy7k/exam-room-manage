@props([
    'href' => '#', 
    'room' => '0',
    'floor' => '0',
    'valid_seat' => '0',
    'total_seat' => '0',
    'selected_room_applicant_quantity' => '0',
    'selectedroom_valid_seat' => '0',
    'selected_room_id',
    'building_name',
    'exam_id',
    'recent_change' => 'null'
])

<div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg"">
    <a href="{{ route('exam-roomdetail', ['examId' => $exam_id,'selected_room_id' => $selected_room_id]) }}" class="absolute inset-0 z-0"></a>
    <div class="px-4 py-3 text-surface text-black">
        <div class="group flex">
            <span class="relative group flex hover-trigger">
                <x-tooltip title="{{ $room }} ชั้น {{ $floor }}" class="group-hover:translate-y-4 z-20"></x-tooltip>
                <p class="text-2xl -my-1 font-semibold max-w-28 truncate">
                    {{ $room }}
                </p>
                <p class="text-gray-600 -my-1 pl-2 py-1.5">
                    ชั้น {{ $floor }}
                </p>
            </span> 
        </div>
        <div class="flex justify-end -mx-2 -mt-8 gap-2">
            @if ($recent_change == 1)
                <span class="flex group hover-trigger relative overflow-visable">
                    <x-tooltip title="ผังห้องเปลี่ยนแปลง" class="absolute group-hover:translate-y-6 -translate-x-10"></x-tooltip>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 translate-y-1.5 fill-orange-500" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M23,11c0-2.206-1.794-4-4-4v-2c0-2.757-2.243-5-5-5h-4c-2.757,0-5,2.243-5,5v2c-2.206,0-4,1.794-4,4v5c0,.017,0,.035,.001,.052,.028,1.63,1.362,2.948,2.999,2.948h7v3H7c-.552,0-1,.447-1,1s.448,1,1,1h10c.552,0,1-.447,1-1s-.448-1-1-1h-4v-3h7c1.637,0,2.971-1.318,2.999-2.948,0-.017,.001-.034,.001-.052v-5Zm-2,0v2.172c-.313-.111-.649-.172-1-.172h-1v-4c1.103,0,2,.897,2,2ZM7,5c0-1.654,1.346-3,3-3h4c1.654,0,3,1.346,3,3V13H7V5Zm-2,4v4h-1c-.351,0-.687,.061-1,.172v-2.172c0-1.103,.897-2,2-2Zm15,8H4c-.551,0-1-.448-1-1s.449-1,1-1H20c.551,0,1,.448,1,1s-.449,1-1,1Z"/></svg>
                </span>
            @endif
            <p class="flex px-2 pt-1.5 pb-1 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                {{ $selected_room_applicant_quantity }} ที่นั่ง
            </p>
        </div>
        <span class="relative group flex hover-trigger">
            <x-tooltip title="{{ $building_name }}" class="group-hover:translate-y-4 z-20"></x-tooltip>
            <p class="text-gray-600 -my-1 py-1.5 max-w-28 truncate">
                {{ $building_name }}
            </p>
        </span> 
        <div class="flex justify-between pb-1 pt-3">
            <x-buttons.primary type="button" class="py-1.5 px-12 z-10"
                onclick="window.location.href = '{{ route('exam-roomdetail', ['examId' => $exam_id,'selected_room_id' => $selected_room_id]) }}'">
                เลือก
            </x-buttons.primary>
        </div>
    </div>
</div>

<script>

</script>