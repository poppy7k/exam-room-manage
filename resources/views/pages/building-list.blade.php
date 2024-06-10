@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-y-2 divide-gray-300">
    <div class="flex justify-between items-center">
        <p class="font-semibold text-2xl justify-start">อาคารสอบทั้งหมด</p>
        <div class="flex">
            <div class="search-container px-2">
                <input class="px-2 pt-1 pb-1" type="text" id="search-input" placeholder="Search by building name..." style="width: 100%; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <x-buttons.icon-primary type="submit" onclick="window.location.href = '{{ route('pages.building-create') }}'" class="px-1 py-1 z-40">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" viewBox="0 0 512 512" width="16" height="16">
                    <g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>
                </svg>
                <x-tooltip title="สร้างอาคารสอบ" class="group-hover:-translate-x-12"></x-tooltip>
            </x-buttons.icon-primary>
        </div>
    </div>
    <div class="grid 2xl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-2">
        @foreach ($buildings as $building)
            @php
                $totalValidSeats = $building->examRoomInformation->sum('valid_seat');
            @endphp
            <x-building-card
                :building_image="'https://images.unsplash.com/photo-1554629947-334ff61d85dc?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1024&h=1280&q=80'"
                :building_th="$building->building_th"
                :building_en="$building->building_en"
                :building_id="$building->id"
                :valid_seat="$totalValidSeats"
            />
        @endforeach
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Building</h3>
                            <div class="mt-2">
                                <div class="mb-4">
                                    <label for="building_th" class="block text-gray-700">Building TH:</label>
                                    <input type="text" name="building_th" id="building_th" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="building_en" class="block text-gray-700">Building EN:</label>
                                    <input type="text" name="building_en" id="building_en" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="building_image" class="block text-gray-700">Building Image:</label>
                                    <input type="file" name="building_image" id="building_image" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(building) {
        document.getElementById('editForm').action = `/buildings/${building.id}/ajax`;
        document.getElementById('building_th').value = building.building_th;
        document.getElementById('building_en').value = building.building_en;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var action = this.action;

        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else {
                alert(data.error || 'Failed to update the building.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.getElementById('search-input').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var buildingItems = document.getElementsByClassName('building-item');

        Array.from(buildingItems).forEach(function(item) {
            var buildingName = item.textContent.toLowerCase();
            if (buildingName.includes(searchQuery)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endsection
