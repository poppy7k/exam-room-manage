@extends('layouts.main')

@section('content')
<div class="bg-white w-full shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class="pb-2 text-2xl font-bold">สร้างการสอบ</p>
    <form id="exam_form" method="POST" class="pt-4" action="{{ route('exams.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="flex mb-4 justify-between">
            <div class="">
                <label for="exam_date" class="block font-semibold">วันที่การสอบ</label>
                <input type="date" id="exam_date" name="exam_date" required class="w-full my-2 px-3 py-1 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                <span id="exam_date_error" class="error-message" style="color: red; display: none;"></span>
            </div>
            <div class="">
                <label for="exam_start_time" class="block font-semibold">เวลาเริ่มการสอบ</label>
                <input list="time_list" type="text" id="exam_start_time" name="exam_start_time" placeholder="เวลาเริ่มการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                <span id="exam_start_time_error" class="error-message" style="color: red; display: none;">* กรุณากรอกเวลา 00:00 และหน่วยนาทีเป็น 00, 30 เท่านั้น!</span>
            </div>
            <div class="">
                <label for="exam_end_time" class="block font-semibold">เวลาสิ้นสุดการสอบ</label>
                <input list="time_list" type="text" id="exam_end_time" name="exam_end_time" placeholder="เวลาสิ้นสุดการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                <span id="exam_end_time_error" class="error-message" style="color: red; display: none;">* กรุณากรอกเวลา 00:00 และหน่วยนาทีเป็น 00, 30 เท่านั้น!</span>
                <datalist id="time_list">
                    @for ($hour = 0; $hour < 24; $hour++)
                        @for ($minute = 0; $minute < 60; $minute += 30)
                            <option value="{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}"></option>
                        @endfor
                    @endfor
                </datalist>
            </div>
        </div>
        <div class="mb-4">
            <label for="department_name" class="block font-semibold">ชื่อฝ่ายงาน</label>
            <input list="department_list" type="text" id="department_name" name="department_name" placeholder="กรอกชื่อฝ่ายงาน" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="department_name_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่อฝ่ายงานให้ถูกต้อง</span>
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
        </div>
        <div class="mb-4">
            <label for="exam_position" class="block font-semibold">ตำแหน่ง</label>
            <input type="text" list="exam_position_list" id="exam_position" name="exam_position" placeholder="กรอกชื่อตำแหน่ง" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="exam_position_error" class="error-message" style="color: red; display: none;">* กรุณากรอกตำแหน่งให้ถูกต้อง</span>
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
        </div>
        <div class="mb-4">
            <label for="subject" class="block font-semibold">ชื่อวิชา</label>
            <input type="text" id="subject" name="subject" placeholder="กรอกชื่อวิชา" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="subject_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่อวิชาให้ถูกต้อง</span>
        </div>
        <div class="mb-4">
            <div class="flex items-center">
                <label for="exam_takers_quantity" class="block font-semibold">จำนวนผู้เข้าสอบ</label>
                <p id="exam_takers_quantity" class="mx-2">0</p><p>คน&nbsp;</p>
                <button type="button" id="edit_button" class="text-blue-500 hover:text-blue-700">แก้ไข</button>
            </div>
        </div>
        <input type="hidden" id="selected_applicants" name="selected_applicants" value="">
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            สร้างการสอบ
        </x-buttons.primary>
        
    </form>
</div>

<!-- Popup Modal -->
<div id="applicant_modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-1/2 p-4 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">เลือกผู้เข้าสอบ</h2>
        <div class="overflow-y-auto max-h-60 mb-4" id="applicant_list">
            <!-- Applicants will be dynamically added here -->
        </div>
        <div class="flex justify-end">
            <button type="button" id="toggle_select_button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">เลือกทั้งหมด</button>
            <button type="button" id="modal_submit_button" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">ตกลง</button>
            <button type="button" id="modal_close_button" class="bg-red-500 text-white px-4 py-2 ml-2 rounded hover:bg-red-700">ยกเลิก</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('department_name').addEventListener('input', updateExamTakersQuantity);
    document.getElementById('department_name').addEventListener('change', updateExamTakersQuantity);
    document.getElementById('exam_position').addEventListener('input', updateExamTakersQuantity);
    document.getElementById('exam_position').addEventListener('change', updateExamTakersQuantity);

    document.getElementById('edit_button').addEventListener('click', function() {
        var examTakersQuantity = parseInt(document.getElementById('exam_takers_quantity').innerText);
        if (examTakersQuantity > 0) {
            fetchApplicants();
            document.getElementById('applicant_modal').classList.remove('hidden');
        }
    });

    document.getElementById('modal_close_button').addEventListener('click', function() {
        document.getElementById('applicant_modal').classList.add('hidden');
    });

    document.getElementById('modal_submit_button').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.applicant_checkbox');
        var selectedApplicants = [];

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedApplicants.push(checkbox.value);
            }
        });

        document.getElementById('selected_applicants').value = selectedApplicants.join(',');
        document.getElementById('exam_takers_quantity').innerText = selectedApplicants.length;
        document.getElementById('applicant_modal').classList.add('hidden');
    });

    document.getElementById('toggle_select_button').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.applicant_checkbox');
        var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !allChecked;
        });

        this.innerText = allChecked ? 'เลือกทั้งหมด' : 'ไม่เลือกทั้งหมด';
    });

    function updateExamTakersQuantity() {
        var department = document.getElementById('department_name').value;
        var position = document.getElementById('exam_position').value;
        fetch(`/fetch-applicants?department=${department}&position=${position}`)
            .then(response => response.json())
            .then(data => {
                //console.log('Fetched applicants:', data); // Debugging line
                document.getElementById('exam_takers_quantity').innerText = data.length;
                document.getElementById('selected_applicants').value = data.map(applicant => applicant.id).join(',');
            })
            .catch(error => {
                console.error('Error fetching applicants:', error);
            });
    }

    function fetchApplicants() {
        var department = document.getElementById('department_name').value;
        var position = document.getElementById('exam_position').value;

        fetch(`/fetch-applicants?department=${department}&position=${position}`)
            .then(response => response.json())
            .then(data => {
                //console.log('Fetched applicants for modal:', data); // Debugging line
                var applicantList = document.getElementById('applicant_list');
                applicantList.innerHTML = '';

                data.forEach(applicant => {
                    var applicantDiv = document.createElement('div');
                    applicantDiv.classList.add('flex', 'items-center', 'mb-2');

                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `applicant_${applicant.id}`;
                    checkbox.classList.add('applicant_checkbox');
                    checkbox.value = applicant.id;
                    checkbox.checked = document.getElementById('selected_applicants').value.split(',').includes(applicant.id.toString());

                    var label = document.createElement('label');
                    label.htmlFor = `applicant_${applicant.id}`;
                    label.classList.add('ml-2');
                    label.textContent = applicant.name;

                    applicantDiv.appendChild(checkbox);
                    applicantDiv.appendChild(label);
                    applicantList.appendChild(applicantDiv);
                });

                updateToggleButtonText();
                addCheckboxListeners();
            })
            .catch(error => {
                console.error('Error fetching applicants:', error);
            });
    }

    function updateToggleButtonText() {
        var checkboxes = document.querySelectorAll('.applicant_checkbox');
        var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        document.getElementById('toggle_select_button').innerText = allChecked ? 'ไม่เลือกทั้งหมด' : 'เลือกทั้งหมด';
    }

    function addCheckboxListeners() {
        var checkboxes = document.querySelectorAll('.applicant_checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateToggleButtonText);
        });
    }

    function validateForm() {
        var isValid = true;
        
        var departmentFound = false;
        var positionFound = false;

        var departmentName = document.getElementById('department_name');
        var departmentOptions = document.getElementById('department_list').getElementsByTagName('option');
        var departmentNameError = document.getElementById('department_name_error');

        var positionName = document.getElementById('exam_position');
        var positionOptions = document.getElementById('exam_position_list').getElementsByTagName('option');
        var positionNameError = document.getElementById('exam_position_error');

        var examStartTime = document.getElementById('exam_start_time');
        var examStartTimeError = document.getElementById('exam_start_time_error');

        var examEndTime = document.getElementById('exam_end_time');
        var examEndTimeError = document.getElementById('exam_end_time_error');
        var regex = /^(?:2[0-3]|[01]?[0-9]):(00|30)$/; // เช็ครูปแบบเวลา HH:MM

        var examDate = document.getElementById('exam_date');
        var examDateError = document.getElementById('exam_date_error');
        
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

        // //comment for testing exam status
        // if (startHour > endHour || (startHour === endHour && startMinute >= endMinute)) {
        //     examStartTimeError.style.display = 'block';
        //     examStartTimeError.textContent = '* เวลาเริ่มต้นการสอบต้องเริ่มก่อนเวลาสิ้นสุดการสอบ';
        //     isValid = false;
        // } else {
        //     examStartTimeError.style.display = 'none';
        // }

        // Validate department is in datalist
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

        // Validate position is in datalist
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

        // Validate department and position combination
        var examTakersQuantity = calculateExamTakers(departmentName.value, positionName.value);
        if (examTakersQuantity === 0) {
            departmentNameError.textContent = '* โปรดเลือกชื่อฝ่ายงานและตำแหน่งให้ตรงกัน';
            departmentNameError.style.display = 'block';
            isValid = false;
        } else {
            departmentNameError.style.display = 'none';
        }

        // //Validate not before today //comment for testing exam status
        // if (selectedDate < today) {
        //     examDateError.textContent = '* ไม่สามารถเลือกวันที่หลังจากวันนี้ได้';
        //     examDateError.style.display = 'block';
        //     examDate.value = '';
        //     isValid = false;
        // } else {
        //     examDateError.style.display = 'none';
        // }
        
        return isValid;
    }

    function calculateExamTakers(department, position) {
        var examTakersQuantity = 0;
        @foreach($applicants as $applicant)
            if ('{{ $applicant->department }}' === department && '{{ $applicant->position }}' === position) {
                examTakersQuantity++;
            }
        @endforeach
        return examTakersQuantity;
    }
</script>
@endsection