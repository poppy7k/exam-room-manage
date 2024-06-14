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
            <p class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->total_seat }}</p> 
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                แถว
            </p>
            <p class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p> 
            <p class="font-normal text- justify-start ml-4 mt-1.5">
                คอลัมน์
            </p>
            <p class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p> 
        </div> 
        <div class="flex">
        </div>
    </div>
    <div class="bg-white shadow-lg my-3 rounded-lg max-h-screen flex flex-col">
        <!-- Div ด้านบน -->
        <div onclick="" class="bg-white rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
            <div class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.primary class="mx-auto mt-4 my-2 -rotate-90 rounded-full group-hover:scale-110 fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                </x-buttons.primary>
                <p class="text-sm font-semibold">
                    เพิ่มคอลัมน์ด้านบน
                </p>
            </div>
        </div>
        
        <div class="flex flex-grow">
            <!-- Div ด้านซ้าย -->
            <div onclick="" class="bg-white rounded-lg w-12 flex-shrink-0 text-center py-4 group hover:w-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
                <div class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                    <x-buttons.primary class="mb-2 rotate-180 rounded-full group-hover:scale-110 fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    </x-buttons.primary>
                    <p class="text-sm font-semibold">
                        เพิ่มแถวด้านซ้าย
                    </p>
                </div>
            </div>
             <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-11/12 h-96">
            <!-- Seats will be generated by JavaScript -->
        </div>
    
            <!-- Div ด้านขวา -->
            <div onclick="" class="bg-white rounded-lg w-12 flex-shrink-0 text-center py-4 group hover:w-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
                <div class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                    <x-buttons.primary class="mb-2 rounded-full group-hover:scale-110 fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    </x-buttons.primary>
                    <p class="text-sm font-semibold">
                        เพิ่มแถวด้านขวา
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Div ด้านล่าง -->
        <div class="bg-white rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
            <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.primary class="mx-auto mt-4 my-2 rotate-90 rounded-full group-hover:scale-110 fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                </x-buttons.primary>
                <p class="text-sm font-semibold">
                    เพิ่มคอลัมน์ด้านล่าง
                </p>
            </div>
        </div>
    </div>
</div>
<form id="addSeatForm" method="POST" action="{{ route('examroominfo.saveSelectedSeats', ['buildingId' => $room->building_code, 'roomId' => $room->id]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="saveSeats()">
    @csrf
    @method('PUT')
    <input type="hidden" id="selectedSeatsInput" name="selected_seats">
    <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
        บันทึกที่นั่ง
    </x-buttons.primary>
</form>

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
        const rows = {{ $room->rows }};
        const columns = {{ $room->columns }};
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

    let selectedSeats = @json($selectedSeats) || [];

    function toggleSeat(row, column) {
        const seatId = `${row}-${column}`;
        if (!Array.isArray(selectedSeats)) {
            selectedSeats = [];
        }

        if (selectedSeats.includes(seatId)) {
            selectedSeats = selectedSeats.filter(id => id !== seatId);
            document.getElementById(`seat-${seatId}`).innerHTML = `
                <x-seats.primary>
                    ${seatId}
                </x-seats.primary>
            `;
        } else {
            selectedSeats.push(seatId);
            document.getElementById(`seat-${seatId}`).innerHTML = `
                <x-seats.unavailable>
                    ${seatId}
                </x-seats.unavailable>
            `;
        }

        console.log('Selected Seats:', selectedSeats);

        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    function saveSeats() {
        console.log('Saving Seats:', selectedSeats);
        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    document.addEventListener('DOMContentLoaded', addSeats);
</script>

@endsection

