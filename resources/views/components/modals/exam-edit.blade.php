@props([
    'departments' => [],
    'positions' => [],
    'applicants' => [],
])

<div id="edit-exam-modal" class="fixed z-40 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 w-screen h-screen"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="edit-exam-form" method="POST" action="{{ route('update-exam') }}" onsubmit="return validateForm()">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 pt-3 text-center sm:mt-0 sm:ml-4 sm:text-left divide-y-2 w-full mr-4">
                            <h3 class="text-2xl font-semibold">แก้ไขข้อมูลการสอบ</h3>
                            <div class="grid grid-cols-2 gap-12 mt-4">
                                <div>
                                    <input type="hidden" name="exam_id" id="edit-exam-id">
                                    <div class="mb-4">
                                        <label for="edit-department_name" class="block font-semibold">ชื่อฝ่ายงาน</label>
                                        <input list="department_list" type="text" id="edit-department_name" name="department_name" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
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
                                        <input type="text" list="exam_position_list" id="edit-exam_position" name="exam_position" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
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
                                        <label for="edit-subject" class="block font-semibold">วิชา</label>
                                        <input type="text" id="edit-subject" name="subject" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                        <span id="edit-subject_error" class="error-message" style="color: red; display: none;">* กรุณากรอกวิชาให้ถูกต้อง</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <label for="edit-exam_date" class="block font-semibold">วันที่สอบ</label>
                                        <input type="date" id="edit-exam_date" name="exam_date" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                        <span id="edit-exam_date_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกวันที่ที่ถูกต้อง</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="edit-exam_start_time" class="block font-semibold">เวลาที่เริ่มสอบ</label>
                                        <input list="time_list" type="text" id="edit-exam_start_time" name="exam_start_time" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                        <span id="edit-exam_start_time_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกเวลาจากรายการ</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="edit-exam_end_time" class="block font-semibold">เวลาที่สิ้นสุดสอบ</label>
                                        <input list="time_list" type="text" id="edit-exam_end_time" name="exam_end_time" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                        <span id="edit-exam_end_time_error" class="error-message" style="color: red; display: none;">* กรุณาเลือกเวลาจากรายการ</span>
                                        <datalist id="time_list">
                                            @for ($hour = 0; $hour < 24; $hour++)
                                                @for ($minute = 0; $minute < 60; $minute += 30)
                                                    <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}"></option>
                                                @endfor
                                            @endfor
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <div class="flex pt-4 pr-4 gap-4">
                        <x-buttons.secondary type="button" class="hover:scale-105 py-2 w-12 justify-center" onclick="closeExamEditModal()">
                            Cancel
                        </x-buttons.secondary>
                        <x-buttons.primary type="submit" class="hover:scale-105 py-2 px-12 w-12 justify-center" onclick="">
                            Save
                        </x-buttons.primary>
                    </div>
                </div>
            </form>
        </div>
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
                const examSubject = this.dataset.examSubject;

                document.getElementById('edit-exam-id').value = examId;
                document.getElementById('edit-department_name').value = departmentName;
                document.getElementById('edit-exam_position').value = examPosition;
                document.getElementById('edit-exam_date').value = examDate;
                document.getElementById('edit-exam_start_time').value = examStartTime.substr(11, 5);
                document.getElementById('edit-exam_end_time').value = examEndTime.substr(11, 5); 
                document.getElementById('edit-subject').value = examSubject;

                document.getElementById('edit-exam-modal').classList.remove('hidden');
            });
        });

        window.applicants = @json($applicants);
    });

    function closeExamEditModal() {
            document.getElementById('edit-exam-modal').classList.add('hidden');
        }

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