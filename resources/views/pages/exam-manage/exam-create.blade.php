@extends('layouts.main')

@section('content')
<div class="bg-white w-full shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class ="pb-2 text-2xl font-bold">
        สร้างการสอบ
    </p>
    <form method="POST" class="pt-4" action="#" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="flex mb-4 justify-between">
            <div class="">
                <label for="exam_date" class="block font-semibold">วันที่การสอบ</label>
                <input type="date" id="exam_date" name="exam_date" class="my-2 px-3 py-1 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
            <div class="">
                <label for="exam_start_time" class="block font-semibold">เวลาเริ่มการสอบ</label>
                <input type="text" list="exam_start_list" id="exam_start_time" name="exam_start_time" placeholder="เวลาเริ่มการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                <datalist id="exam_start_list">
                    <option value="Option 1"></option>
                    <option value="Option 2"></option>
                    <option value="Option 3"></option>
                 </datalist>
            </div>
            <div class="">
                <label for="exam_end_time" class="block font-semibold">เวลาสิ้นสุดการสอบ</label>
                <input type="text" list="exam_end_list" id="exam_end_time" name="exam_end_time" placeholder="เวลาสิ้นสุดการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                <datalist id="exam_end_list">
                    <option value="Option 1"></option>
                    <option value="Option 2"></option>
                    <option value="Option 3"></option>
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
        var buildingTh = document.getElementById('building_th').value.trim();
        var buildingEn = document.getElementById('building_en').value.trim();
        var thaiPattern = /^[ก-๙0-9\s]+$/;
        var englishPattern = /^[A-Za-z0-9\s]+$/;
        var buildingThError = document.getElementById('building_th_error');
        var buildingEnError = document.getElementById('building_en_error');
        if (!thaiPattern.test(buildingTh)) {
            buildingThError.style.display = 'block';
            isValid = false;
        } else {
            buildingThError.style.display = 'none';
        }
        if (!englishPattern.test(buildingEn)) {
            buildingEnError.style.display = 'block';
            isValid = false;
        } else {
            buildingEnError.style.display = 'none';
        }
        return isValid;
    }
</script>
@endsection