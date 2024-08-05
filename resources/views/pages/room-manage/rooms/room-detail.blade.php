@extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex">
            <p class="font-semibold align-baseline text-2xl">
                {{ $room->room }}
            </p>
            <p class="font-normal text-md ml-4 mt-1.5">
                ชั้น
            </p>
            <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                ที่นั่งว่าง
            </p>
            <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                ที่นั่งทั้งหมด
            </p>
            <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->total_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                แถว
            </p>
            <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                คอลัมน์
            </p>
            <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p>
        </div>
        <div class="flex">
        </div>
    </div>
    <div class="bg-white shadow-md my-6 rounded-lg max-h-screen flex flex-col">
        <!-- Div ด้านบน -->
        <div class="bg-white grow rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div class="absolute group-hover:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180 w-7 h-7" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M18.71,8.21a1,1,0,0,0-1.42,0l-4.58,4.58a1,1,0,0,1-1.42,0L6.71,8.21a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l4.59,4.59a3,3,0,0,0,4.24,0l4.59-4.59A1,1,0,0,0,18.71,8.21Z"/></svg>
            </div>
            <div onclick="addRow('top')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="เพิ่มแถวด้านบน" class="-translate-x-8 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="removeRow('top')" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="ลบแถวด้านบน" class="-translate-x-7 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>

        <div class="flex flex-grow">
            <!-- Div ด้านซ้าย -->
            <div class="bg-white rounded-lg w-12 flex-shrink-0 text-center py-4 group hover:w-28 transition-all duration-500 flex flex-col gap-4 justify-center items-center ">
                <div class="absolute group-hover:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90 w-7 h-7" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M18.71,8.21a1,1,0,0,0-1.42,0l-4.58,4.58a1,1,0,0,1-1.42,0L6.71,8.21a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l4.59,4.59a3,3,0,0,0,4.24,0l4.59-4.59A1,1,0,0,0,18.71,8.21Z"/></svg>
                </div>
                <div onclick="addColumn('left')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center">
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="เพิ่มคอลัมน์ด้านซ้าย" class="-translate-x-10 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="removeColumn('left')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center">
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="ลบคอลัมน์ด้านซ้าย" class="-translate-x-9 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
            <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96">
                <!-- Seats will be generated by JavaScript -->
            </div>

            <!-- Div ด้านขวา -->
            <div class="bg-white grow rounded-lg w-12 flex-shrink-0 text-center py-4 gap-4 group hover:w-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
                <div class="absolute group-hover:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90 w-7 h-7" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M18.71,8.21a1,1,0,0,0-1.42,0l-4.58,4.58a1,1,0,0,1-1.42,0L6.71,8.21a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l4.59,4.59a3,3,0,0,0,4.24,0l4.59-4.59A1,1,0,0,0,18.71,8.21Z"/></svg>
                </div>
                <div onclick="addColumn('right')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="เพิ่มคอลัมน์ด้านขวา" class="-translate-x-10 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="removeColumn('right')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="ลบคอลัมน์ด้านขวา" class="-translate-x-9 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
        </div>

        <!-- Div ด้านล่าง -->
        <div class="bg-white rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div class="absolute group-hover:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M18.71,8.21a1,1,0,0,0-1.42,0l-4.58,4.58a1,1,0,0,1-1.42,0L6.71,8.21a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l4.59,4.59a3,3,0,0,0,4.24,0l4.59-4.59A1,1,0,0,0,18.71,8.21Z"/></svg>
            </div>
            <div onclick="addRow('bottom')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="เพิ่มแถวด้านล่าง" class="-translate-x-8 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="removeRow('bottom')" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="ลบแถวด้านล่าง" class="-translate-x-7 hidden group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>
    </div>
</div>
<form id="addSeatForm" method="POST" action="{{ route('examroominfo.saveInvalidSeats', ['buildingId' => $room->building_id, 'roomId' => $room->id]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="saveSeats(event)">
    @csrf
    @method('PUT')
    <input type="hidden" id="invalidSeatsInput" name="invalid_seats">
    <input type="hidden" id="validSeatCountInput" name="valid_seat">
    <input type="hidden" id="rowsInput" name="rows">
    <input type="hidden" id="columnsInput" name="columns">
    <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
        บันทึกที่นั่ง
    </x-buttons.primary>
</form>

<!-- Exam Status Modal -->
<div id="exam-status-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">รายการสอบที่มีผลกระทบต่อการเปลี่ยนแปลงที่นั้ง</h3>
            <button id="close-exam-status-modal-btn" class="text-red-500">&times;</button>
        </div>
        <div id="exam-list" class="max-h-64 overflow-y-auto">
            <!-- Exam list will be populated here -->
        </div>
        <div class="flex justify-end mt-4">
            <button id="submit-exam-status-btn" class="px-5 py-2 bg-blue-500 text-white rounded">ตกลง</button>
        </div>
    </div>
</div>
<input type="hidden" id="examIdsInput">


<script>
    let validSeatCount = {{ $room->valid_seat }};
    let invalidSeats = JSON.parse(@json($room->invalid_seats) || "[]");
    
    function toExcelColumn(n) {
        let result = '';
        while (n >= 0) {
            result = String.fromCharCode((n % 26) + 65) + result;
            n = Math.floor(n / 26) - 1;
        }
        return result;
    }
    
    function addSeats() {
        const rows = parseInt(document.getElementById('row-count').textContent);
        const columns = parseInt(document.getElementById('column-count').textContent);
        const seatContainer = document.getElementById('seat-container');
        seatContainer.innerHTML = '';
        seatContainer.style.gridTemplateColumns = `repeat(${columns}, minmax(4rem, 1fr))`;
    
        let seatComponents = '';
        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                const seatId = `${i + 1}-${toExcelColumn(j)}`;
                let seatComponent = '';
                if (invalidSeats.includes(seatId)) {
                    seatComponent = `
                        <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.unavailable>${i + 1}-${toExcelColumn(j)}</x-seats.unavailable>
                        </div>
                    `;
                } else {
                    seatComponent = `
                        <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.primary>${i + 1}-${toExcelColumn(j)}</x-seats.primary>
                        </div>
                    `;
                }
                seatComponents += seatComponent;
            }
        }
        seatContainer.innerHTML = seatComponents;
    }
    
    function toggleSeat(row, column) {
        const seatId = `${row}-${column}`;
        console.log('Before Toggle:', invalidSeats);
    
        if (invalidSeats.includes(seatId)) {
            invalidSeats = invalidSeats.filter(id => id !== seatId);
            validSeatCount++;
            document.getElementById(`seat-${seatId}`).innerHTML = `<x-seats.primary>${seatId}</x-seats.primary>`;
        } else {
            invalidSeats.push(seatId);
            validSeatCount--;
            document.getElementById(`seat-${seatId}`).innerHTML = `<x-seats.unavailable>${seatId}</x-seats.unavailable>`;
        }
    
        console.log('After Toggle:', invalidSeats);
    
        document.getElementById('validSeatCount').textContent = validSeatCount;
    
        document.getElementById('invalidSeatsInput').value = JSON.stringify(invalidSeats);
        document.getElementById('validSeatCountInput').value = validSeatCount;
    }
    
    function saveSeats(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        document.getElementById('invalidSeatsInput').value = JSON.stringify(invalidSeats);
        document.getElementById('validSeatCountInput').value = validSeatCount;
        document.getElementById('rowsInput').value = document.getElementById('row-count').textContent;
        document.getElementById('columnsInput').value = document.getElementById('column-count').textContent;
        
        showExamStatusModal(); // Show the modal to confirm the exam status updates
    }
    
    function showExamStatusModal() {
    //console.log('Invalid Seats:', invalidSeats); 
    const rows = document.getElementById('row-count').textContent;
    const columns = document.getElementById('column-count').textContent;
    fetch('/exams-with-affected-layouts', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            invalidSeats: invalidSeats,
            roomId: {{ $room->id }},
            rows: rows,
            columns: columns
        })
    })
    .then(response => response.json())
    .then(exams => {
        const examList = document.getElementById('exam-list');
        examList.innerHTML = '';

        exams.forEach(exam => {
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'exam-item');
            div.innerHTML = `<p>${exam.name}</p>`;
            examList.appendChild(div);
        });

        // Store the exam IDs in a hidden field or a variable
        const examIds = exams.map(exam => exam.id);
        document.getElementById('examIdsInput').value = JSON.stringify(examIds);

        document.getElementById('exam-status-modal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error fetching exams:', error);
        alert('An error occurred while fetching exams.');
    });
}

document.getElementById('close-exam-status-modal-btn').addEventListener('click', function() {
    document.getElementById('exam-status-modal').classList.add('hidden');
});

document.getElementById('submit-exam-status-btn').addEventListener('click', function() {
    const examIds = JSON.parse(document.getElementById('examIdsInput').value);
    const rows = document.getElementById('row-count').textContent;
    const columns = document.getElementById('column-count').textContent;
    console.log('Selected Exams:', examIds);

    fetch('/update-exam-seat-layouts', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            exams: examIds,
            invalidSeats: invalidSeats,
            roomId: {{ $room->id }},
            rows: rows,
            columns: columns
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert('Exam statuses updated successfully.');
            document.getElementById('exam-status-modal').classList.add('hidden');
            document.getElementById('addSeatForm').submit();
        } else {
            alert('Failed to update exam statuses.');
        }
    })
    .catch(error => {
        console.error('Error updating exam statuses:', error);
        alert('An error occurred while updating exam statuses.');
    });
});
function addColumn(position) {
    let columns = parseInt(document.getElementById('column-count').textContent);
    columns++;
    document.getElementById('column-count').textContent = columns;
    if (position === 'left') {
        invalidSeats = invalidSeats.map(seat => {
            const [row, col] = seat.split('-');
            const colIndex = col.charCodeAt(0) - 65 + 1;
            return `${row}-${toExcelColumn(colIndex)}`;
        });
    }
        
    addSeats();
    updateValidSeatCount();
    updateTotalSeatCount();
    }

function removeColumn(position) {
    let columns = parseInt(document.getElementById('column-count').textContent);
    if (columns > 1) {
        columns--;
        document.getElementById('column-count').textContent = columns;
        if (position === 'right') {
            invalidSeats = invalidSeats.filter(seat => {
                const col = seat.split('-')[1];
                return col.charCodeAt(0) - 65 < columns;
        });
        } else if (position === 'left') {
            invalidSeats = invalidSeats.map(seat => {
                const [row, col] = seat.split('-');
                const colIndex = col.charCodeAt(0) - 65 - 1;
                return `${row}-${toExcelColumn(colIndex)}`;
            }).filter(seat => {
                const col = seat.split('-')[1];
                return col.charCodeAt(0) - 65 >= 0;
            });
        }
        addSeats();
        updateValidSeatCount();
        updateTotalSeatCount();
    }
}
function addRow(position) {
    let rows = parseInt(document.getElementById('row-count').textContent);
    rows++;
    document.getElementById('row-count').textContent = rows;
    if (position === 'top') {
        invalidSeats = invalidSeats.map(seat => {
            const [row, col] = seat.split('-');
            return `${parseInt(row) + 1}-${col}`;
    });
}
    addSeats();
    updateValidSeatCount();
    updateTotalSeatCount();
}
function removeRow(position) {
    let rows = parseInt(document.getElementById('row-count').textContent);
    if (rows > 1) {
        rows--;
        document.getElementById('row-count').textContent = rows;
        if (position === 'bottom') {
            invalidSeats = invalidSeats.filter(seat => {
                const row = seat.split('-')[0];
                return parseInt(row) <= rows;
            });
        } else if (position === 'top') {
            invalidSeats = invalidSeats.map(seat => {
                const [row, col] = seat.split('-');
                return `${parseInt(row) - 1}-${col}`;
            }).filter(seat => {
                const row = seat.split('-')[0];
                return parseInt(row) >= 1;
});
        }
        addSeats();
        updateValidSeatCount();
        updateTotalSeatCount();
    }
}
function updateValidSeatCount() {
    const rows = parseInt(document.getElementById('row-count').textContent);
    const columns = parseInt(document.getElementById('column-count').textContent);
    const totalSeats = rows * columns;
    const occupiedSeats = invalidSeats.length;
    validSeatCount = totalSeats - occupiedSeats;
    document.getElementById('validSeatCount').textContent = validSeatCount;
}
function updateTotalSeatCount() {
    const rows = parseInt(document.getElementById('row-count').textContent);
    const columns = parseInt(document.getElementById('column-count').textContent);
    const totalSeats = rows * columns;
    document.getElementById('totalSeatCount').textContent = totalSeats;
}

document.addEventListener('DOMContentLoaded', addSeats);
</script>

@endsection

