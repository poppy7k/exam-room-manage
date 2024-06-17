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
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <!-- Div ด้านบน -->
        <div class="bg-white grow rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div onclick="addRow('top')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="เพิ่มแถวด้านบน" class="-translate-x-10 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="removeRow('top')" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="ลบแถวด้านบน" class="-translate-x-9 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>

        <div class="flex flex-grow">
            <!-- Div ด้านซ้าย -->
            <div class="bg-white rounded-lg w-12 flex-shrink-0 text-center py-4 group hover:w-28 transition-all duration-500 flex flex-col gap-4 justify-center items-center ">
                <div onclick="addColumn('left')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center">
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="เพิ่มคอลัมน์ด้านซ้าย" class="-translate-x-8 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="removeColumn('left')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center">
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="ลบคอลัมน์ด้านซ้าย" class="-translate-x-7 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
            <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96">
                <!-- Seats will be generated by JavaScript -->
            </div>

            <!-- Div ด้านขวา -->
            <div class="bg-white grow rounded-lg w-12 flex-shrink-0 text-center py-4 gap-4 group hover:w-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
                <div onclick="addColumn('right')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="เพิ่มคอลัมน์ด้านขวา" class="-translate-x-8 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="removeColumn('right')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                            <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                        </svg>
                        <x-tooltip title="ลบคอลัมน์ด้านขวา" class="-translate-x-7 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
        </div>

        <!-- Div ด้านล่าง -->
        <div class="bg-white rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div onclick="addRow('bottom')" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="เพิ่มแถวด้านล่าง" class="-translate-x-10 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="removeRow('bottom')" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center">
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/>
                        <path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/>
                    </svg>
                    <x-tooltip title="ลบแถวด้านล่าง" class="-translate-x-9 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>
    </div>
</div>
<form id="addSeatForm" method="POST" action="{{ route('examroominfo.saveSelectedSeats', ['buildingId' => $room->building_code, 'roomId' => $room->id]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="saveSeats()">
    @csrf
    @method('PUT')
    <input type="hidden" id="selectedSeatsInput" name="selected_seats">
    <input type="hidden" id="validSeatCountInput" name="valid_seat">
    <input type="hidden" id="rowsInput" name="rows">
    <input type="hidden" id="columnsInput" name="columns">
    <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
        บันทึกที่นั่ง
    </x-buttons.primary>
</form>

<script>
let validSeatCount = {{ $room->valid_seat }};
let selectedSeats = JSON.parse(@json($room->selected_seats) || "[]");

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
            if (selectedSeats.includes(seatId)) {
                seatComponent = `
                    <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                        <x-seats.unavailable>
                            ${i + 1}-${toExcelColumn(j)}
                        </x-seats.unavailable>
                    </div>
                `;
            } else {
                seatComponent = `
                    <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${seatId}" class="seat p-4 text-center cursor-pointer">
                        <x-seats.primary>
                            ${i + 1}-${toExcelColumn(j)}
                        </x-seats.primary>
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
    console.log('Before Toggle:', selectedSeats);

    if (selectedSeats.includes(seatId)) {
        selectedSeats = selectedSeats.filter(id => id !== seatId);
        validSeatCount++;
        document.getElementById(`seat-${seatId}`).innerHTML = `
            <x-seats.primary>
                ${seatId}
            </x-seats.primary>
        `;
    } else {
        selectedSeats.push(seatId);
        validSeatCount--;
        document.getElementById(`seat-${seatId}`).innerHTML = `
            <x-seats.unavailable>
                ${seatId}
            </x-seats.unavailable>
        `;
    }

    console.log('After Toggle:', selectedSeats);

    document.getElementById('validSeatCount').textContent = validSeatCount;

    document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    document.getElementById('validSeatCountInput').value = validSeatCount;
}

function saveSeats() {
    document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    document.getElementById('validSeatCountInput').value = validSeatCount;
    document.getElementById('rowsInput').value = document.getElementById('row-count').textContent;
    document.getElementById('columnsInput').value = document.getElementById('column-count').textContent;
}

function addColumn(position) {
    let columns = parseInt(document.getElementById('column-count').textContent);
    columns++;
    document.getElementById('column-count').textContent = columns;

    if (position === 'left') {
        selectedSeats = selectedSeats.map(seat => {
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
            selectedSeats = selectedSeats.filter(seat => {
                const col = seat.split('-')[1];
                return col.charCodeAt(0) - 65 < columns;
            });
        } else if (position === 'left') {
            selectedSeats = selectedSeats.map(seat => {
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
        selectedSeats = selectedSeats.map(seat => {
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
            selectedSeats = selectedSeats.filter(seat => {
                const row = seat.split('-')[0];
                return parseInt(row) <= rows;
            });
        } else if (position === 'top') {
            selectedSeats = selectedSeats.map(seat => {
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
    const occupiedSeats = selectedSeats.length;
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
