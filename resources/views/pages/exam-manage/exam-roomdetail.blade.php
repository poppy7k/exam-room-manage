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
        <div class="flex"> </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96 p-4"></div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col p-4">
        <h2 class="text-xl font-semibold mb-4">ผู้คุมสอบ</h2>
        <ul>นายทดสอบ ทดสอบ</ul>
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
</script>

@endsection







