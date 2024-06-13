@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-y-2 divide-gray-300 w-full">
    <div class="flex justify-between items-center">
        <div class="flex"> 
            <p class="font-semibold text-2xl justify-start">
                ชื่อห้อง: {{ $room->room }}
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                ชั้น: {{ $room->floor }}
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                จำนวนที่นั่ง: {{ $room->total_seat }}
            </p>
        </div> 
        <div class="flex">
            <p class="font-semibold text-2xl justify-start ml-4">
                แถว: {{ $room->rows }}
            </p>
            <p class="font-semibold text-2xl justify-start ml-4">
                คอลัมน์: {{ $room->columns }}
            </p>
        </div>
    </div>
    <div class="bg-white shadow-lg px-10 py-10 my-3 border-1 rounded-lg">
        <div id="seat-container" class="grid grid-cols-{{ $room->columns }} gap-2 h-screen overflow-x-scroll overflow-y-scroll">
        </div>
    </div>
</div>

<div class="bg-white shadow-lg px-16 py-10 my-3 border-1 rounded-lg divide-y-2">
    <p class="pb-2 text-2xl font-bold">
        เพิ่มที่นั่ง
    </p>
    <form id="addSeatForm" method="POST" action="{{ route('examroominfo.saveSelectedSeats', ['buildingId' => $room->building_code, 'roomId' => $room->id]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="saveSeats()">
        @csrf
        @method('PUT')
        <input type="hidden" id="selectedSeatsInput" name="selected_seats">
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            บันทึกที่นั่ง
        </x-buttons.primary>
        <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">เพิ่มที่นั่ง</button>
    </form>
    {{-- <form id="addSeatForm" method="POST" action="{{ route('examroominfo.saveSelectedSeats', ['buildingId' => $room->building_code, 'roomId' => $room->id]) }}" class="pt-4" enctype="multipart/form-data" onsubmit="saveSeats()">
        @csrf
        @method('PUT')
        <input type="hidden" id="selectedSeatsInput" name="selected_seats">
        <input type="hidden" id="oldSelectedSeatsInput" name="old_selected_seats" value="{{ json_encode($selectedSeats) }}">
        <x-buttons.primary type="submit" class="py-2 w-full hover:scale-105 justify-center">
            บันทึกที่นั่ง
        </x-buttons.primary>
        <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">เพิ่มที่นั่ง</button>
    </form> --}}
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
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let backgroundColor = '';
            if (selectedSeats.includes(seatId)) {
                backgroundColor = '#FF0000';
            }
            seatComponents += `
                <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${i}-${j}" class="p-4 text-center bg-gray-200 hover:bg-gray-300 cursor-pointer" style="background-color: ${backgroundColor}">
                    ${i + 1}-${toExcelColumn(j)}
                </div>
            `;
        }
    }
    seatContainer.innerHTML = seatComponents;
}

    let selectedSeats = @json($selectedSeats);

    function toggleSeat(row, column) {
        const seatId = `${row}-${column}`;
        const seatElement = document.getElementById(`seat-${row - 1}-${column.charCodeAt(0) - 65}`);

        if (!Array.isArray(selectedSeats)) {
            selectedSeats = [];
        }

        if (selectedSeats.includes(seatId)) {
            selectedSeats = selectedSeats.filter(id => id !== seatId); 
            seatElement.style.backgroundColor = ''; 
        } else {
            selectedSeats.push(seatId); 
            seatElement.style.backgroundColor = '#FF0000'; 
        }

        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    function saveSeats() {
        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    document.addEventListener('DOMContentLoaded', addSeats);
</script>

{{-- <script>
    // Function to convert numeric column index to Excel-style column letter
    function toExcelColumn(n) {
        let result = '';
        while (n >= 0) {
            result = String.fromCharCode((n % 26) + 65) + result;
            n = Math.floor(n / 26) - 1;
        }
        return result;
    }

    // Function to add seats dynamically based on rows and columns
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
                let backgroundColor = '';
                if (selectedSeats.includes(seatId)) {
                    backgroundColor = '#FF0000'; // Set background color to red for selected seats
                }
                seatComponents += `
                    <div onclick="toggleSeat(${i + 1}, '${toExcelColumn(j)}')" id="seat-${i}-${j}" 
                         class="p-4 text-center bg-gray-200 hover:bg-gray-300 cursor-pointer" 
                         style="background-color: ${backgroundColor}">
                        ${i + 1}-${toExcelColumn(j)}
                    </div>
                `;
            }
        }
        seatContainer.innerHTML = seatComponents;
    }

    // Initialize selectedSeats with the existing selected seats from Laravel
    let selectedSeats = @json($selectedSeats);

    // Function to toggle seat selection
    function toggleSeat(row, column) {
        const seatId = `${row}-${column}`;
        const seatElement = document.getElementById(`seat-${row - 1}-${column.charCodeAt(0) - 65}`);

        // Ensure selectedSeats is initialized as an array
        if (!Array.isArray(selectedSeats)) {
            selectedSeats = [];
        }

        // Clone the old selectedSeats array to maintain old values
        const oldSelectedSeats = [...selectedSeats];

        // Toggle seat selection
        if (selectedSeats.includes(seatId)) {
            selectedSeats = selectedSeats.filter(id => id !== seatId); // Deselect seat
            seatElement.style.backgroundColor = ''; // Clear background color
        } else {
            selectedSeats.push(seatId); // Select seat
            seatElement.style.backgroundColor = '#FF0000'; // Set background color to red
        }

        // Save old values of selected seats to hidden input
        document.getElementById('oldSelectedSeatsInput').value = JSON.stringify(oldSelectedSeats);
        // Update current selected seats to hidden input
        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    // Function to save seats without submitting the form
    function saveSeats() {
        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedSeats);
    }

    // Call addSeats function to generate seats on page load
    document.addEventListener('DOMContentLoaded', addSeats);
</script> --}}

@endsection

