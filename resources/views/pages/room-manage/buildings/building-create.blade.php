@extends('layouts.main')

@section('content')
<div class="bg-white w-full shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class ="pb-2 text-2xl font-bold">
        สร้างอาคารสอบ
    </p>
    <form method="POST" class="pt-4" action="{{ route('buildings.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="mb-4">
            <label for="building_th" class="block font-semibold">ชื่ออาคาร (ภาษาไทย)</label>
            <input type="text" id="building_th" name="building_th" placeholder="กรอกชื่ออาคาร (ภาษาไทย)" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="building_th_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาไทยหรือตัวเลขเท่านั้น!</span>
        </div>
        <div class="mb-4">
            <label for="building_en" class="block font-semibold">ชื่ออาคาร (English)</label>
            <input type="text" id="building_en" name="building_en" placeholder="กรอกชื่ออาคาร (English)" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="building_en_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาอังกฤษหรือตัวเลขเท่านั้น!</span>
        </div>
        <div class="mb-4">
            <label for="building_map_url" class="block font-semibold">ลิ้งค์แผนที่ของอาคารสอบ</label>
            <input type="text" id="building_map_url" name="building_map_url" placeholder="กรอกลิ้งค์แผนที่ของอาคารสอบ" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
        </div>
        <div class="mb-6">
            <label for="building_image" class="block font-semibold">อัปโหลดรูปภาพของอาคาร</label>
            <input type="file" id="building_image" name="building_image" accept="image/*" class="w-full my-2 px-3 py-2  rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none file:rounded-md file:border-0 file:font-semibold file:px-2 file:py-1.5 file:bg-green-200 file:text-green-700 file:text-md hover:file:bg-green-300">
        </div>
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            สร้างอาคารสอบ
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
        if (!englishPattern.test(buildingEn) && !buildingEn === "") {
            buildingEnError.style.display = 'block';
            isValid = false;
        } else {
            buildingEnError.style.display = 'none';
        }
        return isValid;
    }
</script>
@endsection