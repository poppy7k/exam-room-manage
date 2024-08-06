@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">รายการห้องสอบ</p>
            <p class="font-normal text-md px-3 mt-1.5">-</p>
            <p class="font-normal text-md mt-1.5">ทั้งหมด {{ count($selectedRooms) }}</p>
        </div> 
        <button id="show_unassigned_applicants_button" {{ $applicantsWithSeats >= $totalApplicants ? 'disabled' : '' }}>
            {{ $applicantsWithSeats }} / {{ $totalApplicants }}
        </button>
        <div class="flex gap-1">
            <x-buttons.info type="button" class="px-5 py-2 rounded-lg text-white" id="delete-applicants-button">
                ลบผู้เข้าสอบ
            </x-buttons.info>
            <x-buttons.info type="button" class="px-5 py-2 rounded-lg text-white" id="update-applicants-button">
                เพิ่มผู้เข้าสอบ
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

<div id="unassigned_applicants_modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-1/2 p-4 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">ผู้สมัครที่ยังไม่มีที่นั่ง</h2>
        <div class="overflow-y-auto max-h-60 mb-4">
            <ul>
                @foreach($applicantsWithoutSeats as $applicant)
                    <li>{{ $applicant->name }} ({{ $applicant->id_card }})</li>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-end">
            <button type="button" id="modal_close_button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">ปิด</button>
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

    document.getElementById('show_unassigned_applicants_button').addEventListener('click', function() {
        if (this.hasAttribute('disabled')) {
            return;
        }
        document.getElementById('unassigned_applicants_modal').classList.remove('hidden');
    });

    document.getElementById('modal_close_button').addEventListener('click', function() {
        document.getElementById('unassigned_applicants_modal').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', function () {
    const updateButton = document.getElementById('update-applicants-button');
    const deleteButton = document.getElementById('delete-applicants-button');
    const modal = document.getElementById('updateApplicantsModal');
    const deleteModal = document.getElementById('deleteApplicantsModal');
    const cancelUpdateButton = document.getElementById('cancel-update-applicants');
    const cancelDeleteButton = document.getElementById('cancel-delete-applicants');
    const confirmUpdateButton = document.getElementById('confirm-update-applicants');
    const confirmDeleteButton = document.getElementById('confirm-delete-applicants');
    const newApplicantsList = document.getElementById('new-applicants-list');
    const deleteApplicantsList = document.getElementById('delete-applicants-list');
    const selectAllButton = document.getElementById('select-all-applicants');
    const selectAllDeleteButton = document.getElementById('select-all-delete-applicants');
    let allSelected = false;

    updateButton.addEventListener('click', async function () {
        try {
            const response = await fetch('/get-new-applicants/{{ $exams->id }}');
            const data = await response.json();
            newApplicantsList.innerHTML = '';

            if (data.success && data.newApplicants.length > 0) {
                data.newApplicants.forEach(applicant => {
                    const listItem = document.createElement('li');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = applicant.id;
                    checkbox.classList.add('applicant-checkbox');
                    checkbox.addEventListener('change', updateSelectAllButtonState);
                    listItem.appendChild(checkbox);
                    listItem.appendChild(document.createTextNode(` ${applicant.name} (${applicant.id_card})`));
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

    deleteButton.addEventListener('click', async function () {
        try {
            const response = await fetch('/get-applicants-to-delete/{{ $exams->id }}');
            const data = await response.json();
            deleteApplicantsList.innerHTML = '';

            if (data.success && data.applicants.length > 0) {
                data.applicants.forEach(applicant => {
                    const listItem = document.createElement('li');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = applicant.id;
                    checkbox.classList.add('applicant-checkbox-delete');
                    checkbox.addEventListener('change', updateSelectAllDeleteButtonState);
                    listItem.appendChild(checkbox);
                    listItem.appendChild(document.createTextNode(` ${applicant.name} (${applicant.id_card})`));
                    deleteApplicantsList.appendChild(listItem);
                });
                deleteModal.classList.remove('hidden');
            } else {
                alert('No applicants to delete.');
            }
        } catch (error) {
            console.error('Error fetching applicants to delete:', error);
        }
    });

    selectAllButton.addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.applicant-checkbox');
        allSelected = !allSelected;
        checkboxes.forEach(checkbox => checkbox.checked = allSelected);
        selectAllButton.textContent = allSelected ? 'ไม่เลือกทั้งหมด' : 'เลือกทั้งหมด';
    });

    selectAllDeleteButton.addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.applicant-checkbox-delete');
        allSelected = !allSelected;
        checkboxes.forEach(checkbox => checkbox.checked = allSelected);
        selectAllDeleteButton.textContent = allSelected ? 'ไม่เลือกทั้งหมด' : 'เลือกทั้งหมด';
    });

    cancelUpdateButton.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    cancelDeleteButton.addEventListener('click', function () {
        deleteModal.classList.add('hidden');
    });

    confirmUpdateButton.addEventListener('click', async function () {
        const selectedApplicants = Array.from(document.querySelectorAll('.applicant-checkbox:checked')).map(cb => cb.value);

        if (selectedApplicants.length === 0) {
            alert('โปรดเลือกผู้สมัครก่อนกดตกลง');
            return;
        }

        try {
            const response = await fetch('/update-new-applicants/{{ $exams->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ applicants: selectedApplicants }),
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

    confirmDeleteButton.addEventListener('click', async function () {
        const selectedApplicants = Array.from(document.querySelectorAll('.applicant-checkbox-delete:checked')).map(cb => cb.value);

        if (selectedApplicants.length === 0) {
            alert('โปรดเลือกผู้สมัครก่อนกดตกลง');
            return;
        }

        try {
            const response = await fetch('/delete-applicants/{{ $exams->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ applicants: selectedApplicants }),
            });
            const data = await response.json();

            if (data.success) {
                alert('Applicants deleted successfully.');
                deleteModal.classList.add('hidden');
            } else {
                alert('Failed to delete applicants.');
            }
        } catch (error) {
            console.error('Error deleting applicants:', error);
        }
    });

    function updateSelectAllButtonState() {
        const checkboxes = document.querySelectorAll('.applicant-checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

        selectAllButton.textContent = allChecked ? 'ไม่เลือกทั้งหมด' : 'เลือกทั้งหมด';
        allSelected = allChecked;
    }

    function updateSelectAllDeleteButtonState() {
        const checkboxes = document.querySelectorAll('.applicant-checkbox-delete');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

        selectAllDeleteButton.textContent = allChecked ? 'ไม่เลือกทั้งหมด' : 'เลือกทั้งหมด';
        allSelected = allChecked;
    }
});

</script>

@endsection