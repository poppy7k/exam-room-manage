@extends('layouts.main')

@section('content')
<div class="bg-white w-full shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class ="pb-2 text-2xl font-bold">
        สร้างการสอบ
    </p>
    <form method="POST" class="pt-4" action="{{ route('exams.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="mb-4">
            <label for="department_name" class="block font-semibold">ชื่อฝ่ายงาน</label>
            <input list="department_list" type="text" id="department_name" name="department_name" placeholder="กรอกชื่อฝ่ายงาน" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <datalist id="department_list">
                <option value="Option 1"></option>
                <option value="Option 2"></option>
                <option value="Option 3"></option>
             </datalist>
        </div>
        <div class="flex mb-4 justify-between">
            <div class="">
                <label for="exam_date" class="block font-semibold">วันที่การสอบ</label>
                <input type="date" id="exam_date" name="exam_date" class="w-full my-2 px-3 py-1 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
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
            <label for="exam_position" class="block font-semibold">ตำแหน่ง</label>
            <input type="text" list="exam_position_list" id="exam_position" name="exam_position" placeholder="กรอกชื่อตำแหน่ง" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <datalist id="exam_position_list">
                <option value="Option 1"></option>
                <option value="Option 2"></option>
                <option value="Option 3"></option>
             </datalist>
        </div>
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            สร้างการสอบ
        </x-buttons.primary>
    </form>
</div>

<script>
    function validateForm() {
        var isValid = true;
        var examStartTime = document.getElementById('exam_start_time');
        var examStartTimeError = document.getElementById('exam_start_time_error');

        var examEndTime = document.getElementById('exam_end_time');
        var examEndTimeError = document.getElementById('exam_end_time_error');
        var regex = /^(?:2[0-3]|[01]?[0-9]):(00|30)$/; // เช็ครูปแบบเวลา HH:MM
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
        
        return isValid;
    }
</script>
@endsection