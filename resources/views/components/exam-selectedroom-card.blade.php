@props([
    'href' => '#', 
    'room' => '0',
    'floor' => '0',
    'valid_seat' => '0',
    'total_seat' => '0',
    'selected_room_applicant_quantity' => '0',
    'selected_room_id',
    'building_name',
    'exam_id'
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
        <div class="flex justify-end">
            <p class="absolute justify-end -mx-1 -my-7 px-2 py-1 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
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