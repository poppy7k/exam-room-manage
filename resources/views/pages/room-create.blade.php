@extends('layouts.main')

@section('content')

<h1>เพิ่มที่นั่งในห้อง</h1>
<form id="addSeatForm" method="POST" action="{{ route('examroominfo.store', ['buildingId' => $buildingId]) }}" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    @csrf    
    <!-- Input fields for floor and room -->
    <div class="row">
        <label for="floor">Floor:</label>
        <input type="text" id="floor" name="floor" required>
    </div>
    <div class="row">
        <label for="room">Room:</label>
        <input type="text" id="room" name="room" required>
    </div>
    <div class="row">
        <label for="rows">Rows:</label>
        <input type="number" id="rows" name="rows" min="1" required>
    </div>
    <div class="row">
        <label for="columns">Columns:</label>
        <input type="number" id="columns" name="columns" min="1" required>
    </div>
    <div id="seat-container" style="display: flex; flex-wrap: wrap;"></div>
    <div id="seat-info"></div>
    <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Add Seats</button>
    <button type="button" onclick="saveSeats()" style="background-color: #0000FF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Save</button>
</form>

<script>
    function addSeats() {
        const rows = document.getElementById('rows').value;
        const columns = document.getElementById('columns').value;
        const seatContainer = document.getElementById('seat-container');
        seatContainer.innerHTML = '';

        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < columns; j++) {
                const seat = document.createElement('div');
                seat.style.width = '30px';
                seat.style.height = '30px';
                seat.style.border = '1px solid #000';
                seat.style.margin = '2px';
                seat.style.display = 'inline-block';
                seat.style.textAlign = 'center';
                seat.style.lineHeight = '30px';
                seat.textContent = `${i + 1}-${j + 1}`;
                seatContainer.appendChild(seat);
            }
        }
    }

    function saveSeats() {
        const form = document.getElementById('addSeatForm');
        form.submit();
    }
</script>

@endsection

