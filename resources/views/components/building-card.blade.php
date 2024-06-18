@props([
    'href' => '#', 
    'building_image',
    'building_en',
    'building_th',
    'building_id',
    'valid_seat',
    'building_map_url',
])

<div class="building-item relative flex flex-col bg-clip-border w-[260px] rounded-lg bg-white shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg">
    <a href="{{ route('pages.room-list', ['buildingId' => $building_id]) }}" class="absolute inset-0 z-0"></a>
        <div class="flex justify-end">
            <div class="absolute mx-2 my-2 flex">
                @if (!empty($building_map_url))
                <x-buttons.icon-primary-bg onclick="copyToClipboard('{{ $building_map_url }}'); event.stopPropagation();" class="p-1 rounded-full hover:scale-110 fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <x-tooltip title="แผนที่อาคารสอบ" class="group-hover:-translate-x-9"></x-tooltip>
                </x-buttons.icon-primary-bg>
                @else
                <x-buttons.icon-danger-bg onclick="" class="p-1 rounded-full hover:scale-110 fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <x-tooltip title="ยังไม่มีแผนที่อาคารสอบ" class="group-hover:-translate-x-12"></x-tooltip>
                </x-buttons.icon-danger-bg>
                @endif
                <p class="bg-gradient-to-tr ml-2 px-2 pt-2.5 from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md whitespace-nowrap">
                    {{ $valid_seat }} ที่นั่ง
                </p>
            </div>
            
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
                <x-buttons.primary type="button" class="py-1.5 px-12 z-10" onclick="window.location.href = '{{ route('pages.room-list', ['buildingId' => $building_id]) }}'">
                    เลือก
                </x-buttons.primary>
                <x-buttons.icon-info type="button" onclick="event.stopPropagation(); openBuildingEditModal({ id: {{ $building_id }}, building_th: '{{ $building_th }}', building_en: '{{ $building_en }}', building_map_url: '{{ $building_map_url }}' })" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/></svg>
                    <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
                </x-buttons.icon-info>
                <x-buttons.icon-danger type="button" onclick="event.stopPropagation(); deleteBuilding('{{ $building_id }}')" class="px-1 py-1 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                    <x-tooltip title="ลบอาคาร" class="group-hover:-translate-x-5"></x-tooltip>
                </x-buttons.icon-danger>
            </div>
        </div>
</div>

<script>
    function deleteBuilding(buildingId) {
        if (confirm('Are you sure you want to delete this building?')) {
            fetch(`/buildings/${buildingId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Building deleted successfully.');
                    location.reload();
                } else {
                    alert('Failed to delete the building.');
                }
            });
        }
    }
    function copyToClipboard(text) {
        // สร้าง element input ใน DOM
        var input = document.createElement('input');
        input.style.position = 'fixed';
        input.style.opacity = 0;
        input.value = text;
        document.body.appendChild(input);
        
        // เลือก text ใน input
        input.select();
        input.setSelectionRange(0, 99999); // สำหรับส่วนมากของเบราว์เซอร์

        // คัดลอก text ไปยังคลิปบอร์ด
        document.execCommand('copy');

        // ลบ element input ทิ้ง
        document.body.removeChild(input);

        // แสดงข้อความบน console เพื่อแจ้งให้ทราบว่าคัดลอกสำเร็จ
        console.log('Copied to clipboard: ' + text);
        fetch('/set-alert-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: 'คัดลอกแผนที่ของอาคารสอบเสร็จสิ้น!'
            })
        })
        .then(response => {
            // ตรวจสอบ response และแสดง session flash message หรือทำอย่างอื่นตามต้องการ
            if (response.ok) {
                location.reload();
            } else {
                alert('เกิดข้อผิดพลาดในการคัดลอกแผนที่การสอบ');
            }
        });
    }
</script>