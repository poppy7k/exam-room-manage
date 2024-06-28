@extends('layouts.main')

@section('content')
<div id="edit-exam-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">แก้ไขข้อมูลการสอบ</h3>
            <button id="close-edit-exam-modal-btn" class="text-red-500">&times;</button>
        </div>
        <form id="edit-exam-form" method="POST" action="{{ route('update-exam') }}" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <input type="hidden" name="exam_id" id="edit-exam-id">
            <div class="mb-4">
                <label for="edit-department_name" class="block font-semibold">ชื่อฝ่ายงาน</label>
                <input list="department_list" type="text" id="edit-department_name" name="department_name" required class="mt-1 p-2 w-full border rounded-md">
                <datalist id="department_list">
                    @php
                        $addedDepartments = [];
                    @endphp
                    @foreach($departments as $department)
                        @if (!in_array($department, $addedDepartments))
                            <option value="{{ $department }}"></option>
                            @php
                                $addedDepartments[] = $department;
                            @endphp
                        @endif
                    @endforeach
                </datalist>
                <span id="edit-department_name_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่อฝ่ายงานให้ถูกต้อง</span>
            </div>
            <div class="mb-4">
                <label for="edit-exam_position" class="block font-semibold">ตำแหน่งสอบ</label>
                <input type="text" list="exam_position_list" id="edit-exam_position" name="exam_position" required class="mt-1 p-2 w-full border rounded-md">
                <datalist id="exam_position_list">
                    @php
                        $addedPositions = [];
                    @endphp
                    @foreach($positions as $position)
                        @if (!in_array($position, $addedPositions))
                            <option value="{{ $position }}"></option>
                            @php
                                $addedPositions[] = $position;
                            @endphp
                        @endif
                    @endforeach
                </datalist>
                <span id="edit-exam_position_error" class="error-message" style="color: red; display: none;">* กรุณากรอกตำแหน่งให้ถูกต้อง</span>
            </div>
            <div class="mb-4">
                <label for="edit-exam_date" class="block font-semibold">วันที่สอบ</label>
                <input type="date" id="edit-exam_date" name="exam_date" required class="mt-1 p-2 w-full border rounded-md">
                <span id="edit-exam_date_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกวันที่ที่ถูกต้อง</span>
            </div>
            <div class="mb-4">
                <label for="edit-exam_start_time" class="block font-semibold">เวลาที่เริ่มสอบ</label>
                <input list="time_list" type="text" id="edit-exam_start_time" name="exam_start_time" required class="mt-1 p-2 w-full border rounded-md">
                <span id="edit-exam_start_time_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกเวลาจากรายการ</span>
            </div>
            <div class="mb-4">
                <label for="edit-exam_end_time" class="block font-semibold">เวลาที่สิ้นสุดสอบ</label>
                <input list="time_list" type="text" id="edit-exam_end_time" name="exam_end_time" required class="mt-1 p-2 w-full border rounded-md">
                <span id="edit-exam_end_time_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกเวลาจากรายการ</span>
                <datalist id="time_list">
                    @for ($hour = 0; $hour < 24; $hour++)
                        @for ($minute = 0; $minute < 60; $minute += 30)
                            <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}"></option>
                        @endfor
                    @endfor
                </datalist>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded">บันทึก</button>
            </div>
        </form>
    </div>
</div>
<div class="flex flex-col divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">
                การสอบทั้งหมด
            </p>
            <p class="font-normal text-md px-3 mt-1.5">
                -
            </p>
            <p class="font-normal text-md mt-1.5">
                ทั้งหมด {{{ $totalExams }}}
            </p>
        </div> 
        <div class="flex gap-4">
            <div x-data="{ showFilterBuilding: false }" class="z-40"> 
                <x-buttons.icon-primary @click="showFilterBuilding = !showFilterBuilding" id="filter-building" onclick="event.stopPropagation();" class="px-[5px] pt-1.5 pb-1 z-40 from-white to-white">
                    <svg id="Layer_1" class="w-5 h-5" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m14 24a1 1 0 0 1 -.6-.2l-4-3a1 1 0 0 1 -.4-.8v-5.62l-7.016-7.893a3.9 3.9 0 0 1 2.916-6.487h14.2a3.9 3.9 0 0 1 2.913 6.488l-7.013 7.892v8.62a1 1 0 0 1 -1 1zm-3-4.5 2 1.5v-7a1 1 0 0 1 .253-.664l7.268-8.177a1.9 1.9 0 0 0 -1.421-3.159h-14.2a1.9 1.9 0 0 0 -1.421 3.158l7.269 8.178a1 1 0 0 1 .252.664z"/></svg>
                    <x-tooltip title="ฟิลเตอร์อาคารสอบ" class="group-hover:-translate-x-11"></x-tooltip>
                </x-buttons.icon-primary>
                @include('components.dropdowns.building-list.filter')
            </div>
            <div class="search-container">
                <input type="text" id="search-input" placeholder="ค้นหาการสอบ" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
            <x-buttons.icon-primary type="submit" onclick="window.location.href = '{{ route('exam-create') }}'" class="px-[5px] py-1 z-40 from-white to-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16" height="16"><g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192   c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>/</svg>
                <x-tooltip title="สร้างการสอบ" class="group-hover:-translate-x-9"></x-tooltip>
            </x-buttons.icon-primary>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4 mt-2">
        @forelse($exams as $exam)
            <x-exam-card
                :department_name="$exam->department_name"
                :exam_position="$exam->exam_position"
                :exam_date="$exam->exam_date"
                :exam_start_time="$exam->exam_start_time"      
                :exam_end_time="$exam->exam_end_time"
                :exam_id="$exam->id"
                :exam_name="$exam->exam_name"
                :exam_takers_quantity="$exam->exam_takers_quantity"
                :status="$exam->status"
                :organization="$exam->organization"
            />
        @empty

        @endforelse
    </div>
    <div id="empty-state" class="col-span-4 text-center py-32 my-3" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mt-10 mb-5 fill-gray-500" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512.021 512.021;" xml:space="preserve" width="512" height="512">
            <g>
                <path d="M301.258,256.01L502.645,54.645c12.501-12.501,12.501-32.769,0-45.269c-12.501-12.501-32.769-12.501-45.269,0l0,0   L256.01,210.762L54.645,9.376c-12.501-12.501-32.769-12.501-45.269,0s-12.501,32.769,0,45.269L210.762,256.01L9.376,457.376   c-12.501,12.501-12.501,32.769,0,45.269s32.769,12.501,45.269,0L256.01,301.258l201.365,201.387   c12.501,12.501,32.769,12.501,45.269,0c12.501-12.501,12.501-32.769,0-45.269L301.258,256.01z"/>
            </g>
        </svg>        
        <p class ="pb-2 text-center text-gray-500">
            ไม่พบอาคารสอบ
        </p>
    </div>
    <div class="mt-4 col-span-4 mx-auto">
        {{ $exams->links('pagination::bootstrap-4') }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-exam-button').forEach(button => {
            button.addEventListener('click', function () {
                const examId = this.dataset.examId;
                const departmentName = this.dataset.departmentName;
                const examPosition = this.dataset.examPosition;
                const examDate = this.dataset.examDate;
                const examStartTime = this.dataset.examStartTime;
                const examEndTime = this.dataset.examEndTime;

                document.getElementById('edit-exam-id').value = examId;
                document.getElementById('edit-department_name').value = departmentName;
                document.getElementById('edit-exam_position').value = examPosition;
                document.getElementById('edit-exam_date').value = examDate;
                document.getElementById('edit-exam_start_time').value = examStartTime.substr(11, 5);
                document.getElementById('edit-exam_end_time').value = examEndTime.substr(11, 5); 

                document.getElementById('edit-exam-modal').classList.remove('hidden');
            });
        });

        document.getElementById('close-edit-exam-modal-btn').addEventListener('click', function () {
            document.getElementById('edit-exam-modal').classList.add('hidden');
        });

        window.applicants = @json($applicants);
    });

    function validateForm() {
        var isValid = true;
        
        var departmentFound = false;
        var positionFound = false;

        var departmentName = document.getElementById('edit-department_name');
        var departmentOptions = document.getElementById('department_list').getElementsByTagName('option');
        var departmentNameError = document.getElementById('edit-department_name_error');

        var positionName = document.getElementById('edit-exam_position');
        var positionOptions = document.getElementById('exam_position_list').getElementsByTagName('option');
        var positionNameError = document.getElementById('edit-exam_position_error');

        var examStartTime = document.getElementById('edit-exam_start_time');
        var examStartTimeError = document.getElementById('edit-exam_start_time_error');

        var examEndTime = document.getElementById('edit-exam_end_time');
        var examEndTimeError = document.getElementById('edit-exam_end_time_error');
        var regex = /^(?:2[0-3]|[01]?[0-9]):(00|30)$/; // เช็ครูปแบบเวลา HH:MM

        var examDate = document.getElementById('edit-exam_date');
        var examDateError = document.getElementById('edit-exam_date_error');
        
        var selectedDate = new Date(examDate.value);
        var today = new Date();

        var startTimeParts = examStartTime.value.split(':');
        var endTimeParts = examEndTime.value.split(':');

        var startHour = parseInt(startTimeParts[0]);
        var startMinute = parseInt(startTimeParts[1]);
        var endHour = parseInt(endTimeParts[0]);
        var endMinute = parseInt(endTimeParts[1]);

        if (!regex.test(examStartTime.value)) {
            examStartTime.value = "";
            examStartTime.focus();
            isValid = false;
            examStartTimeError.style.display = 'block';
        } else {
            examStartTimeError.style.display = 'none';
        }
        if (!regex.test(examEndTime.value)) {
            examEndTime.value = "";
            examEndTime.focus();
            isValid = false;
            examEndTimeError.style.display = 'block';
        } else {
            examEndTimeError.style.display = 'none';
        }

        if (startHour > endHour || (startHour === endHour && startMinute >= endMinute)) {
            examStartTimeError.style.display = 'block';
            examStartTimeError.textContent = '* เวลาเริ่มต้นการสอบต้องเริ่มก่อนเวลาสิ้นสุดการสอบ';
            isValid = false;
        } else {
            examStartTimeError.style.display = 'none';
        }

        for (var i = 0; i < departmentOptions.length; i++) {
            if (departmentOptions[i].value === departmentName.value) {
                departmentNameError.style.display = 'none';
                departmentFound = true;
                break;
            }
        }
        if (!departmentFound) {
            departmentNameError.style.display = 'block';
            departmentName.value = '';
            isValid = false;
        } else {
            departmentNameError.style.display = 'none';
        }

        for (var i = 0; i < positionOptions.length; i++) {
            if (positionOptions[i].value === positionName.value) {
                positionNameError.style.display = 'none';
                positionFound = true;
                break;
            }
        }
        if (!positionFound) {
            positionNameError.style.display = 'block';
            positionName.value = '';
            isValid = false;
        } else {
            positionNameError.style.display = 'none';
        }

        if (selectedDate < today) {
            examDateError.textContent = '* ไม่สามารถเลือกวันที่ก่อนวันนี้ได้';
            examDateError.style.display = 'block';
            examDate.value = '';
            isValid = false;
        } else {
            examDateError.style.display = 'none';
        }

        if (departmentFound && positionFound) {
            var examTakersQuantity = window.applicants.filter(applicant => 
                applicant.department === departmentName.value && 
                applicant.position === positionName.value
            ).length;

            if (examTakersQuantity === 0) {
                departmentNameError.textContent = 'โปรดเลือกชื่อฝ่ายงานและตำแหน่งให้ตรงกัน';
                departmentNameError.style.display = 'block';
                isValid = false;
            } else {
                departmentNameError.style.display = 'none';
            }
        }
        
        return isValid;
    }
</script>
@endsection