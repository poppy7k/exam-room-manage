@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">รายการห้องสอบ</p>
            <p class="font-normal text-md px-3 mt-1.5">-</p>
            <p class="font-normal text-md mt-1.5">ทั้งหมด {{ count($selectedRooms) }}</p>
        </div> 
        <div class="flex gap-1">
            <x-buttons.info type="button" class="px-5 py-2 rounded-lg text-white" id="update-applicants-button">
                อัปเดตผู้เข้าสอบ
            </x-buttons.info>
            <x-buttons.primary type="button" class="px-5 py-2 rounded-lg text-white"
                onclick="window.location.href = '{{ route('exam-buildinglist', ['examId' => $exams->id]) }}'">
                เลือกห้องใหม่
            </x-buttons.primary>
            <div x-data="{ showFilterExamSelectedRoom: false }" class="z-40"> 
                <x-buttons.icon-primary @click="showFilterExamSelectedRoom = !showFilterExamSelectedRoom" id="filter-exam-selected-room" onclick="event.stopPropagation();" class="px-[5px] pt-1.5 pb-1 z-40">
                    <svg id="Layer_1" class="w-5 h-5" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m14 24a1 1 0 0 1 -.6-.2l-4-3a1 1 0 0 1 -.4-.8v-5.62l-7.016-7.893a3.9 3.9 0 0 1 2.916-6.487h14.2a3.9 3.9 0 0 1 2.913 6.488l-7.013 7.892v8.62a1 1 0 0 1 -1 1zm-3-4.5 2 1.5v-7a1 1 0 0 1 .253-.664l7.268-8.177a1.9 1.9 0 0 0 -1.421-3.159h-14.2a1.9 1.9 0 0 0 -1.421 3.158l7.269 8.178a1 1 0 0 1 .252.664z"/></svg>
                    <x-tooltip title="ฟิลเตอร์อาคารสอบ" class="group-hover:-translate-x-11"></x-tooltip>
                </x-buttons.icon-primary>
                <x-dropdowns.exam-selected-room.filter :examId="$exams->id"/>
            </div>
            <div class="search-container px-2">
                <input type="text" id="search-input" placeholder="ค้นหาห้องสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
        @forelse($selectedRooms as $selectedRoom)
            @if($selectedRoom->room)
                <x-exam-selectedroom-card
                    :room="$selectedRoom->room->room"
                    :floor="$selectedRoom->room->floor"
                    :valid_seat="$selectedRoom->room->valid_seat"
                    :total_seat="$selectedRoom->room->total_seat"      
                    :selected_room_applicant_quantity="$selectedRoom->applicant_seat_quantity"
                    :selected_room_id="$selectedRoom->id"
                    :building_name="$selectedRoom->room->building->building_th"
                    :exam_id="$exams->id"
                    :selectedroom_valid_seat="$selectedRoom->selectedroom_valid_seat"
                    :recent_change="$selectedRoom->recent_change"
                />
            @endif
        @empty
            <div class="col-span-4 text-center py-32 my-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mt-10 mb-5 fill-gray-500" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
                    <g>
                        <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
                    </g>
                </svg>        
                <p class="pb-2 text-center text-gray-500">ไม่พบห้องสอบ</p>
            </div>
        @endforelse
    </div>
</div>
<!-- Modal -->
<div id="updateApplicantsModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 001 1h2a1 1 0 000-2h-1V7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            New Applicants
                        </h3>
                        <div class="mt-2">
                            <ul id="new-applicants-list" class="list-disc list-inside text-sm text-gray-600">
                                <!-- New applicants will be appended here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" id="confirm-update-applicants">
                    Confirm
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm" id="cancel-update-applicants">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-input').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var roomItems = document.getElementsByClassName('room-item');
        var hasVisibleItems = false;

        Array.from(roomItems).forEach(function(item) {
            var roomName = item.textContent.toLowerCase();
            if (roomName.includes(searchQuery)) {
                item.style.display = 'block';
                hasVisibleItems = true
            } else {
                item.style.display = 'none';
            }
        });
        document.getElementById('empty-state').style.display = hasVisibleItems ? 'none' : 'block';
    });

    document.addEventListener('DOMContentLoaded', function () {
    const updateButton = document.getElementById('update-applicants-button');
    const modal = document.getElementById('updateApplicantsModal');
    const cancelUpdateButton = document.getElementById('cancel-update-applicants');
    const confirmUpdateButton = document.getElementById('confirm-update-applicants');
    const newApplicantsList = document.getElementById('new-applicants-list');

    updateButton.addEventListener('click', async function () {
        try {
            const response = await fetch('/get-new-applicants/{{ $exams->id }}');
            const data = await response.json();
            newApplicantsList.innerHTML = '';

            if (data.success && data.newApplicants.length > 0) {
                data.newApplicants.forEach(applicant => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${applicant.name} (${applicant.id_card})`;
                    newApplicantsList.appendChild(listItem);
                });
                modal.classList.remove('hidden');
            } else {
                alert('No new applicants to update.');
            }
        } catch (error) {
            console.error('Error fetching new applicants:', error);
        }
    });

    cancelUpdateButton.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    confirmUpdateButton.addEventListener('click', async function () {
        try {
            const response = await fetch('/update-new-applicants/{{ $exams->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({}),
            });
            const data = await response.json();

            if (data.success) {
                alert('Applicants updated successfully.');
                modal.classList.add('hidden');
            } else {
                alert('Failed to update applicants.');
            }
        } catch (error) {
            console.error('Error updating applicants:', error);
        }
    });
});

</script>
@endsection

