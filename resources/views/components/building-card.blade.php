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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512" height="512"><g id="_01_align_center"><path d="M255.104,512.171l-14.871-12.747C219.732,482.258,40.725,327.661,40.725,214.577c0-118.398,95.981-214.379,214.379-214.379   s214.379,95.981,214.379,214.379c0,113.085-179.007,267.682-199.423,284.932L255.104,512.171z M255.104,46.553   c-92.753,0.105-167.918,75.27-168.023,168.023c0,71.042,110.132,184.53,168.023,236.473   c57.892-51.964,168.023-165.517,168.023-236.473C423.022,121.823,347.858,46.659,255.104,46.553z"/><path d="M255.104,299.555c-46.932,0-84.978-38.046-84.978-84.978s38.046-84.978,84.978-84.978s84.978,38.046,84.978,84.978   S302.037,299.555,255.104,299.555z M255.104,172.087c-23.466,0-42.489,19.023-42.489,42.489s19.023,42.489,42.489,42.489   s42.489-19.023,42.489-42.489S278.571,172.087,255.104,172.087z"/></g></svg>
                    <x-tooltip title="แผนที่อาคารสอบ" class="group-hover:-translate-x-9"></x-tooltip>
                </x-buttons.icon-primary-bg>
                @else
                <x-buttons.icon-danger-bg onclick="" class="p-1 rounded-full hover:scale-110 fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512" height="512"><g id="_01_align_center"><path d="M255.104,512.171l-14.871-12.747C219.732,482.258,40.725,327.661,40.725,214.577c0-118.398,95.981-214.379,214.379-214.379   s214.379,95.981,214.379,214.379c0,113.085-179.007,267.682-199.423,284.932L255.104,512.171z M255.104,46.553   c-92.753,0.105-167.918,75.27-168.023,168.023c0,71.042,110.132,184.53,168.023,236.473   c57.892-51.964,168.023-165.517,168.023-236.473C423.022,121.823,347.858,46.659,255.104,46.553z"/><path d="M255.104,299.555c-46.932,0-84.978-38.046-84.978-84.978s38.046-84.978,84.978-84.978s84.978,38.046,84.978,84.978   S302.037,299.555,255.104,299.555z M255.104,172.087c-23.466,0-42.489,19.023-42.489,42.489s19.023,42.489,42.489,42.489   s42.489-19.023,42.489-42.489S278.571,172.087,255.104,172.087z"/></g></svg>
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