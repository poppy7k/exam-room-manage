@extends('layouts.main')

@section('content')
<div class="bg-white w-full shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class ="pb-2 text-2xl font-bold">
        สร้างการสอบ
    </p>
    <form method="POST" class="pt-4" action="{{ route('exams.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="mb-4">
            <label for="exam_name" class="block font-semibold">ชื่อการสอบ</label>
            <input type="text" list="exam_name_list" id="exam_name" name="exam_name" placeholder="กรอกชื่อการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <datalist id="exam_name_list">
                <option value="Option 1"></option>
                <option value="Option 2"></option>
                <option value="Option 3"></option>
             </datalist>
        </div>
        <div class="mb-4">
            <label for="department_name" class="block font-semibold">ชื่อฝ่ายงาน</label>
            <input type="text" id="department_name" name="department_name" placeholder="กรอกชื่อฝ่ายงาน" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
        </div>
        <div class="flex mb-4 justify-between">
            <div class="">
                <label for="exam_date" class="block font-semibold">วันที่การสอบ</label>
                <input type="date" id="exam_date" name="exam_date" class="w-full my-2 px-3 py-1 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
            <div class="">
                <label for="exam_start_time" class="block font-semibold">เวลาเริ่มการสอบ</label>
                <input type="time" id="exam_start_time" name="exam_start_time" placeholder="เวลาเริ่มการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            </div>
            <div class="">
                <label for="exam_end_time" class="block font-semibold">เวลาสิ้นสุดการสอบ</label>
                <input type="time" id="exam_end_time" name="exam_end_time" placeholder="เวลาสิ้นสุดการสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
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
        // Add your form validation logic here if needed
        return true;
    }
</script>
@endsection