@props([
    'href' => '#', 
    'building_image',
    'building_en',
    'building_th',
    'building_id',
    'valid_seat',
    'examId',
    'buildingId'
])

<div class="building-item relative flex flex-col bg-clip-border w-[260px] rounded-lg bg-white shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg">
    @if ($valid_seat > 0)
    <a href="{{ route('exam-roomlist',['examId' => $examId , 'buildingId' => $buildingId])}}" class="absolute inset-0 z-0"></a>
    @endif
        <div class="flex justify-end">
            @if ($valid_seat > 0)
            <p class="absolute mx-3 my-3 px-2 py-2 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                {{ $valid_seat }} ที่นั่ง
            </p>
            @else
            <p class="absolute mx-3 my-3 px-2 py-2 bg-gradient-to-tr from-red-600 to-red-400 rounded-lg text-sm text-white shadow-md">
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
        {{-- <p>{{$building_image}}</p> --}}
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
                {{-- <x-buttons.primary type="button" class="py-1.5 px-12 z-10" onclick="window.location.href = '{{ route('pages.room-list', ['buildingId' => $building_id]) }}'"> --}}
                @if ($valid_seat > 0)
                <x-buttons.primary type="button" class="py-1.5 px-12 z-10" onclick="window.location.href = '{{ route('exam-roomlist',['examId' => $examId , 'buildingId' => $buildingId])}}'">
                    เลือก
                </x-buttons.primary>
                @else
                <x-buttons.danger type="button" class="py-1.5 px-12 z-10">
                    ไม่สามารถเลือกได้
                </x-buttons.danger>
                @endif
                {{-- <x-buttons.icon-info type="button" onclick="event.stopPropagation(); openBuildingEditModal({ id: {{ $building_id }}, building_th: '{{ $building_th }}', building_en: '{{ $building_en }}' })" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/></svg>
                    <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
                </x-buttons.icon-info>
                <x-buttons.icon-danger type="button" onclick="event.stopPropagation(); deleteBuilding('{{ $building_id }}')" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                    <x-tooltip title="ลบอาคาร" class="group-hover:-translate-x-5"></x-tooltip>
                </x-buttons.icon-danger> --}}
            </div>
        </div>
</div>

<script>
    // function deleteBuilding(buildingId) {
    //     if (confirm('Are you sure you want to delete this building?')) {
    //         fetch(`/buildings/${buildingId}`, {
    //             method: 'DELETE',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'Content-Type': 'application/json'
    //             }
    //         })
    //         .then(response => {
    //             if (response.ok) {
    //                 alert('Building deleted successfully.');
    //                 location.reload();
    //             } else {
    //                 alert('Failed to delete the building.');
    //             }
    //         });
    //     }
    // }
</script>