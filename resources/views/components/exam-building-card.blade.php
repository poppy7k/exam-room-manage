@props([
    'href' => '#', 
    'building_image',
    'building_en',
    'building_th',
    'building_id',
    'valid_seat',
    'selected_seat',
    'examId',
    'buildingId'
])

<div class="building-item relative flex flex-col bg-clip-border w-[260px] rounded-lg bg-white shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg">
    @if (($valid_seat - $selected_seat) > 0)
    <a href="{{ route('exam-roomlist',['examId' => $examId , 'buildingId' => $buildingId])}}" class="absolute inset-0 z-0"></a>
    @endif
        <div class="flex justify-end">
            @if ($valid_seat - $selected_seat > 0)
            <p class="absolute mx-2 my-2 px-2 py-2 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                {{ $valid_seat - $selected_seat }} ที่นั่ง
            </p>
            @else
            <p class="absolute mx-2 my-2 px-2 py-2 bg-gradient-to-tr from-red-600 to-red-400 rounded-lg text-sm text-white shadow-md">
                ไม่ว่าง
            </p>
            @endif
            <img
            class="rounded-t-lg w-full h-48 object-fill"
            src="{{ $building_image }}"
            alt="{{ $building_th . 'building_image'}}" 
            onerror="this.onerror=null;this.src='{{ asset('storage/building_images/default/default-building-image.jpg') }}';"
            />
        </div>
        <div class="p-4 text-surface text-black">
            <div class="group w-auto">
                <p class="mb-0 text-xl font-bold leading-tight truncate building-th">
                    <span class="hover-trigger relative">
                        {{ $building_th }}
                        <x-tooltip title="{{ $building_th }}" class="group-hover:-translate-x-0 group-hover:-translate-y-2 z-10"></x-tooltip>
                    </span>
                    
                </p>
            </div>
            <div class="group">
                <p class="mb-4 text-base truncate building-en">
                    <span class="hover-trigger relative">
                        {{ $building_en }}
                        <x-tooltip title="{{ $building_en }}" class="group-hover:-translate-x-0 group-hover:-translate-y-8 z-10"></x-tooltip>
                    </span>
                </p>
            </div>
            <div class="flex justify-between py-1">
                @if ($valid_seat > 0)
                <x-buttons.primary type="button" class="py-1.5 px-12 z-10" onclick="window.location.href = '{{ route('exam-roomlist',['examId' => $examId , 'buildingId' => $buildingId])}}'">
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
