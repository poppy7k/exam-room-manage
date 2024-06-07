@props([
    'href' => '#', 
    'building_image',
    'building_en',
    'building_th',
    'building_id'
])

<div class="relative flex flex-col bg-clip-border w-[260px] rounded-lg bg-white shadow-md mt-6 transition-all duration-500 hover:scale-105  hover:shadow-lg">
    <a href="{{ $href }}">
        <div class="flex justify-end">
            <p class="absolute mx-3 my-3 px-2 py-2 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                คงเหลือ 999 ที่นั่ง
            </p>
            <img
            class="rounded-t-lg w-full h-48 object-fill"
            src="{{ $building_image }}"
            alt="{{ $building_th . 'building_image'}}" 
            />
        </div>
        <div class="p-4 text-surface text-black">
            <div class="group w-auto">
                <p class="mb-0 text-xl font-bold leading-tight truncate">
                    {{ $building_th }}
                    <x-tooltip title="{{ $building_th }}" class="group-hover:-translate-x-0 group-hover:-translate-y-2"></x-tooltip>
                </p>
            </div>
            <div class="group">
                <p class="mb-4 text-base truncate">
                    {{ $building_en }}
                    <x-tooltip title="{{ $building_en }}" class="group-hover:-translate-x-0 group-hover:-translate-y-6"></x-tooltip>
                </p>
            </div>
            <div class="flex justify-between pt-1">
                <button type="button" class="group inline-block rounded bg-gradient-to-tr from-green-600 to-green-400 shadow-md shadow-green-500/20 hover:shadow-lg hover:shadow-green-500/40 transition duration-500 ease-in-out hover:scale-105 px-12">
                    <p class="text-white">
                        เลือก
                    </p>
                </button>
                <x-buttons.icon-info type="submit" class="px-1 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg"  class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/></svg>
                    <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
                </x-buttons.icon-info>
                <x-buttons.icon-danger type="delete" onclick="deleteBuilding('{{ $building_id }}') class="px-1 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                    <x-tooltip title="ลบอาคาร" class="group-hover:-translate-x-5"></x-tooltip>
                </x-buttons.icon-danger>
            </div>
          </div>
    </a>
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
</script>