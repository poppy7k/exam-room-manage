@extends('layouts.main')

@section('content')

<div class="bg-white shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class ="pb-2 text-2xl font-bold">
        สร้างห้องสอบ
    </p>
    <form id="addSeatForm" method="POST" action="{{ route('examroominfo.store', ['buildingId' => $buildingId]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="">
        @csrf
        <div class="mb-4">
            <label for="room_create_floor" class="block font-semibold">ชั้น</label>
            <input type="text" id="room_create_floor" name="room_create_floor" placeholder="กรอกชั้นของห้องสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="room_create_floor_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาไทยหรือตัวเลขเท่านั้น!</span>
        </div>
        <div class="mb-4">
            <label for="room_create_room" class="block font-semibold">ชื่อห้องสอบ</label>
            <input type="text" id="room_create_room" name="room_create_room" placeholder="กรอกชื่อของห้องสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="room_create_room_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาอังกฤษหรือตัวเลขเท่านั้น!</span>
        </div>
        <div class="mb-4">
            <label for="room_create_rows" class="block font-semibold">จำนวนแถว (แนวตั้ง)</label>
            <input type="number" min="1" max="100" id="room_create_rows" name="room_create_rows" placeholder="กรอกจำนวนแถวของที่นั่งในห้องสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="room_create_rows_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาอังกฤษหรือตัวเลขเท่านั้น!</span>
        </div>
        <div class="mb-4">
            <label for="room_create_columns" class="block font-semibold">จำนวนคอลัมน์ (แนวนอน)</label>
            <input type="number" min="1" max="100" id="room_create_columns" name="room_create_columns" placeholder="กรอกจำนวนคอลัมน์ของที่นั่งในห้องสอบ" required class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
            <span id="room_create_columns_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาอังกฤษหรือตัวเลขเท่านั้น!</span>
        </div>
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            สร้างห้องสอบ
        </x-buttons.primary>
        <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Add Seats</button>
    </form>
</div>

<div class="bg-white shadow-lg px-10 py-10 my-3 border-1 rounded-lg divide-y-2">
    <div id="seat-container" class="grid h-96 overflow-x-scroll overflow-y-scroll"></div>
</div>

<script>
    function toExcelColumn(n) {
        let result = '';
        while (n >= 0) {
            result = String.fromCharCode((n % 26) + 65) + result;
            n = Math.floor(n / 26) - 1;
        }
        return result;
    }
    function addSeats() {
        const rows = document.getElementById('room_create_rows').value;
        const columns = document.getElementById('room_create_columns').value;
        const seatContainer = document.getElementById('seat-container');
        seatContainer.innerHTML = '';
        seatContainer.style.gridTemplateColumns = `repeat(${columns}, minmax(4rem, 1fr))`;

        let seatComponents = '';
        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                seatComponents += `
                    <x-seats.unavailable>
                        ${i + 1}-${toExcelColumn(j)}
                    </x-seats.unavailable>
                `;
            }
        }
        seatContainer.innerHTML = seatComponents;
    }
    function saveSeats() {
        const form = document.getElementById('addSeatForm');
        form.submit();
    }

    //seat.textContent = `${i + 1}-${toExcelColumn(j)}`;
</script>

@endsection

