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
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <!-- Div ด้านบน -->
        <div class="bg-white grow rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    <x-tooltip title="เพิ่มคอลัมน์ด้านบน" class="-translate-x-10 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    <x-tooltip title="ลบคอลัมน์ด้านบน" class="-translate-x-9 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>
        
        <div class="flex flex-grow">
            <!-- Div ด้านซ้าย -->
            <div class="bg-white rounded-lg w-12 flex-shrink-0 text-center py-4 group hover:w-28 transition-all duration-500 flex flex-col gap-4 justify-center items-center ">
                <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center"> 
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                        <x-tooltip title="เพิ่มแถวด้านซ้าย" class="-translate-x-8 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col gap-4 items-center"> 
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                        <x-tooltip title="ลบแถวด้านซ้าย" class="-translate-x-7 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
            <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96">
            <!-- Seats will be generated by JavaScript -->
            </div>
    
            <!-- Div ด้านขวา -->
            <div id="room-detail-right-div" class="bg-white grow rounded-lg w-12 flex-shrink-0 text-center py-4 gap-4 group hover:w-28 transition-all duration-500 flex flex-col justify-center items-center cursor-pointer">
                <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                    <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-0" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                        <x-tooltip title="เพิ่มแถวด้านขวา" class="-translate-x-8 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-primary-bg>
                </div>
                <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                    <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                        <x-tooltip title="ลบแถวด้านขวา" class="-translate-x-7 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                    </x-buttons.icon-danger-bg>
                </div>
            </div>
        </div>
        
        <!-- Div ด้านล่าง -->
        <div class="bg-white rounded-lg h-12 text-center group hover:h-28 transition-all duration-500 flex gap-4 justify-center items-center">
            <div onclick="" class="transition-all duration-500 opacity-0 group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.icon-primary-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    <x-tooltip title="เพิ่มคอลัมน์ด้านล่าง" class="-translate-x-10 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-primary-bg>
            </div>
            <div onclick="" class="transition-all duration-500 opacity-0 group/tooltip group-hover:opacity-100 flex flex-col items-center"> 
                <x-buttons.icon-danger-bg class="group/custombutton mx-auto p-0.5 rounded-full hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Bold" viewBox="0 0 24 24" width="24" height="24"><path d="M13.1,19.5a1.5,1.5,0,0,1-1.061-2.561l4.586-4.585a.5.5,0,0,0,0-.708L12.043,7.061a1.5,1.5,0,0,1,2.121-2.122L18.75,9.525a3.505,3.505,0,0,1,0,4.95l-4.586,4.586A1.5,1.5,0,0,1,13.1,19.5Z"/><path d="M6.1,19.5a1.5,1.5,0,0,1-1.061-2.561L9.982,12,5.043,7.061A1.5,1.5,0,0,1,7.164,4.939l6,6a1.5,1.5,0,0,1,0,2.122l-6,6A1.5,1.5,0,0,1,6.1,19.5Z"/></svg>
                    <x-tooltip title="ลบคอลัมน์ด้านล่าง" class="-translate-x-9 hidden group-hover:opacity-0 group-hover/custombutton:block group-hover:scale-90 group-hover/custombutton:opacity-100 group-hover/custombutton:transition-all group-hover/custombutton:duration-500"></x-tooltip>
                </x-buttons.icon-danger-bg>
            </div>
        </div>
    </div>
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
    const rows = {{ $room->rows }};
    const columns = {{ $room->columns }};
    const seatContainer = document.getElementById('seat-container');
    seatContainer.innerHTML = '';
    seatContainer.style.gridTemplateColumns = `repeat(${columns}, minmax(4rem, 1fr))`;

        let seatComponents = '';
        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                seatComponents += `
                    <x-seats.primary>
                        ${i + 1}-${toExcelColumn(j)}
                    </x-seats.primary>
                `;
            }
        }
        seatContainer.innerHTML = seatComponents;
    }

    let selectedSeats = [];

    function toggleSeat(row, column) {
        const seatId = `${row}-${column}`;
        const seatElement = document.getElementById(`seat-${row - 1}-${column.charCodeAt(0) - 65}`);
        if (selectedSeats.includes(seatId)) {
            const index = selectedSeats.indexOf(seatId);
            if (index > -1) {
                selectedSeats.splice(index, 1);
            }
            seatElement.style.backgroundColor = '';
        } else {
            selectedSeats.push(seatId);
            seatElement.style.backgroundColor = '#FF0000'; 
        }
        // Debugging: Log selectedSeats array
        console.log(selectedSeats);
        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    function saveSeats() {
        const form = document.getElementById('addSeatForm');
        form.submit();
    }

    // Call addSeats function to generate seats on page load
    document.addEventListener('DOMContentLoaded', addSeats);

</script>

@endsection

