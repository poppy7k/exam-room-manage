{{-- @extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex">
            <p class="font-semibold align-baseline text-2xl">
                {{ $room->room }}
            </p>
            <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
            <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
            <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
            <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->total_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> แถว </p>
            <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> คอลัมน์ </p>
            <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p>
        </div>
        <div class="flex">
            <button id="select-examiners-btn" class="px-5 py-2 bg-blue-500 text-white rounded">เลือกผู้คุมสอบ</button>
        </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96 p-4"></div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col p-4">
        <h2 class="text-xl font-semibold mb-4">ผู้คุมสอบ</h2>
        <ul>นายทดสอบ ทดสอบ</ul>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col p-4">
        <h2 class="text-xl font-semibold mb-4">ผู้คุมสอบ</h2>
        <ul id="selected-examiners-list"></ul>
    </div>
</div>
<!-- Examiner selection modal -->
<div id="examiners-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">เลือกผู้คุมสอบ</h3>
            <button id="close-modal-btn" class="text-red-500">&times;</button>
        </div>
        <input type="text" id="search-staff-input" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="ค้นหาชื่อผู้คุมสอบ">
        <div id="staff-list" class="max-h-64 overflow-y-auto">
            <!-- Staff list will be populated here -->
        </div>
        <div class="flex justify-end mt-4">
            <button id="save-examiners-btn" class="px-5 py-2 bg-blue-500 text-white rounded">บันทึก</button>
        </div>
    </div>
</div>

<script>

let validSeatCount = {{ $room->valid_seat }};
const applicants = {!! json_encode($applicants) !!};
const selectedSeats = JSON.parse(@json($room->selected_seats) || "[]");

console.log('Applicants:', applicants);
console.log('Selected Seats:', selectedSeats);

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
    let applicantIndex = 0;

    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < columns; j++) {
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let seatComponent = '';
            const isDeactivated = selectedSeats.includes(seatId);

            if (isDeactivated) {
                seatComponent = `
                    <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                        <x-seats.unavailable>
                            ${seatId}
                        </x-seats.unavailable>
                    </div>
                `;
            } else {
                const applicant = applicants[applicantIndex];
                if (applicant) {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.assigned applicant="${applicant.id_number}">
                                ${seatId}
                            </x-seats.assigned>
                        </div>
                    `;
                    applicantIndex++;
                    validSeatCount--;
                } else {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.primary>
                                ${seatId}
                            </x-seats.primary>
                        </div>
                    `;
                }
            }
            seatComponents += seatComponent;
        }
    }
    document.getElementById('validSeatCount').textContent = validSeatCount;
    seatContainer.innerHTML = seatComponents;
}

document.addEventListener('DOMContentLoaded', addSeats);
document.getElementById('select-examiners-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.remove('hidden');
    loadStaffs();
});

document.getElementById('close-modal-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('save-examiners-btn').addEventListener('click', function() {
    const selectedExaminers = Array.from(document.querySelectorAll('.staff-checkbox:checked')).map(checkbox => {
        return {
            id: checkbox.value,
            name: checkbox.dataset.name
        };
    });

    const selectedExaminersList = document.getElementById('selected-examiners-list');
    selectedExaminersList.innerHTML = '';

    selectedExaminers.forEach(examiner => {
        const li = document.createElement('li');
        li.textContent = examiner.name;
        selectedExaminersList.appendChild(li);
    });

    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('search-staff-input').addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();
    const staffItems = document.querySelectorAll('.staff-item');

    staffItems.forEach(item => {
        const staffName = item.textContent.toLowerCase();
        if (staffName.includes(searchQuery)) {
            item.classList.remove('hidden');
        } else {
            item.classList.add('hidden');
        }
    });
});

function loadStaffs() {
    fetch('/staffs')
        .then(response => response.json())
        .then(staffs => {
            const staffList = document.getElementById('staff-list');
            staffList.innerHTML = '';

            staffs.forEach(staff => {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'staff-item');
                div.innerHTML = `
                    <input type="checkbox" value="${staff.id}" class="staff-checkbox" data-name="${staff.name}">
                    <p>${staff.name}</p>
                `;
                staffList.appendChild(div);
            });
        });
}
</script>

@endsection --}}

@extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex">
            <p class="font-semibold align-baseline text-2xl">
                {{ $room->room }}
            </p>
            <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
            <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
            <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
            <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->total_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> แถว </p>
            <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> คอลัมน์ </p>
            <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p>
        </div>
        <div class="flex">
            <button id="select-examiners-btn" class="px-5 py-2 bg-blue-500 text-white rounded">เลือกผู้คุมสอบ</button>
        </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96">
            <!-- Seats will be generated by JavaScript -->
        </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col p-4">
        <h2 class="text-xl font-semibold mb-4">ผู้คุมสอบ</h2>
        <ul id="selected-examiners-list"></ul>
    </div>
</div>
<!-- Examiner selection modal -->
<div id="examiners-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">เลือกผู้คุมสอบ</h3>
            <button id="close-modal-btn" class="text-red-500">&times;</button>
        </div>
        <input type="text" id="search-staff-input" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="ค้นหาชื่อผู้คุมสอบ">
        <div id="staff-list" class="max-h-64 overflow-y-auto">
            <!-- Staff list will be populated here -->
        </div>
        <div class="flex justify-end mt-4">
            <button id="save-examiners-btn" class="px-5 py-2 bg-blue-500 text-white rounded">บันทึก</button>
        </div>
    </div>
</div>

<script>
let validSeatCount = {{ $room->valid_seat }};
const applicants = {!! json_encode($applicants) !!};
const seats = {!! json_encode($room->seats) !!};

console.log('Applicants:', applicants);
console.log('Seats:', seats);

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
            const seat = seats.find(seat => seat.row === (i + 1) && seat.column === (j + 1));
            const applicant = seat ? applicants.find(applicant => applicant.id === seat.applicant_id) : null;

            if (seat) {
                if (applicant) {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.assigned applicant="${applicant.id_number}">
                                ${seatId}
                            </x-seats.assigned>
                        </div>
                    `;
                } else {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                            <x-seats.primary>
                                ${seatId}
                            </x-seats.primary>
                        </div>
                    `;
                }
                validSeatCount--;
            } else {
                seatComponent = `
                    <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                        <x-seats.primary>
                            ${seatId}
                        </x-seats.primary>
                    </div>
                `;
            }
            seatComponents += seatComponent;
        }
    }
    document.getElementById('validSeatCount').textContent = validSeatCount;
    seatContainer.innerHTML = seatComponents;
}

document.addEventListener('DOMContentLoaded', addSeats);
document.getElementById('select-examiners-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.remove('hidden');
    loadStaffs();
});

document.getElementById('close-modal-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('save-examiners-btn').addEventListener('click', function() {
    const selectedExaminers = Array.from(document.querySelectorAll('.staff-checkbox:checked')).map(checkbox => {
        return {
            id: checkbox.value,
            name: checkbox.dataset.name
        };
    });

    const selectedExaminersList = document.getElementById('selected-examiners-list');
    selectedExaminersList.innerHTML = '';

    selectedExaminers.forEach(examiner => {
        const li = document.createElement('li');
        li.textContent = examiner.name;
        selectedExaminersList.appendChild(li);
    });

    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('search-staff-input').addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();
    const staffItems = document.querySelectorAll('.staff-item');

    staffItems.forEach(item => {
        const staffName = item.textContent.toLowerCase();
        if (staffName.includes(searchQuery)) {
            item.classList.remove('hidden');
        } else {
            item.classList.add('hidden');
        }
    });
});

function loadStaffs() {
    fetch('/staffs')
        .then(response => response.json())
        .then(staffs => {
            const staffList = document.getElementById('staff-list');
            staffList.innerHTML = '';

            staffs.forEach(staff => {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'staff-item');
                div.innerHTML = `
                    <input type="checkbox" value="${staff.id}" class="staff-checkbox" data-name="${staff.name}">
                    <p>${staff.name}</p>
                `;
                staffList.appendChild(div);
            });
        });
}
</script>

@endsection









