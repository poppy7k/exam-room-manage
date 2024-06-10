{{-- @extends('layouts/main')

@section('content')
    <h2>Add Seats</h2>
    <!-- Add your form and other content here -->
    <h1>เพิ่มที่นั่งในห้อง</h1>
    <form id="seatForm" method="POST" action="{{ route('examroominfo.store') }}" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
        @csrf
        <input type="hidden" name="building_th" value="{{ $buildingId }}">
        <input type="hidden" name="room_id" value="{{ $roomId }}">
        <input type="hidden" name="total_seats" id="totalSeats">
        <input type="hidden" name="valid_seats" id="validSeats">
        <input type="hidden" name="invalid_seats" id="invalidSeats">
        <input type="hidden" name="invalid_seat_positions" id="invalidSeatPositions">
        
        <!-- Input fields for row and column numbers -->
        <div class="row">
            <label for="rows">Rows:</label>
            <input type="number" id="rows" name="rows" min="1" required>
        </div>
        <div class="row">
            <label for="columns">Columns:</label>
            <input type="number" id="columns" name="columns" min="1" required>
        </div>

        <!-- Container for seats -->
        <div id="seat-container" style="display: flex; flex-wrap: wrap;"></div>

        <!-- Information about total seats and invalid seats -->
        <div id="seat-info"></div>

        <!-- Button to add seats -->
        <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Add Seats</button>
        
        <!-- Save button -->
        <button type="button" onclick="saveSeats()" style="background-color: #008CBA; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Save</button>
    </form>

    <script>
        function addSeats() {
            const rows = document.getElementById('rows').value;
            const columns = document.getElementById('columns').value;
            const container = document.getElementById('seat-container');
            const seatInfo = document.getElementById('seat-info');
            container.innerHTML = ''; // Clear previous seats

            let totalSeats = 0;
            let invalidSeats = 0;
            let invalidSeatPositions = [];
            
            for (let row = 1; row <= rows; row++) {
                for (let col = 1; col <= columns; col++) {
                    const seatNumber = `${row}-${col}`;
                    const newSeat = document.createElement('div');
                    newSeat.className = 'seat';
                    newSeat.style.backgroundColor = 'green';
                    newSeat.style.width = '50px'; // Adjust width as needed
                    newSeat.style.height = '50px'; // Adjust height as needed
                    newSeat.style.margin = '5px'; // Adjust margin as needed
                    newSeat.innerText = seatNumber;
                    newSeat.addEventListener('click', function() {
                        if (newSeat.style.backgroundColor === 'green') {
                            newSeat.style.backgroundColor = 'red';
                            invalidSeats++;
                            invalidSeatPositions.push(seatNumber);
                        } else {
                            newSeat.style.backgroundColor = 'green';
                            invalidSeats--;
                            const index = invalidSeatPositions.indexOf(seatNumber);
                            if (index !== -1) {
                                invalidSeatPositions.splice(index, 1);
                            }
                        }
                        updateSeatInfo();
                    });
                    container.appendChild(newSeat);

                    totalSeats++;
                }
            }

            // Display total seats, valid seats, and invalid seats information
            updateSeatInfo();

            function updateSeatInfo() {
                const validSeats = totalSeats - invalidSeats;
                seatInfo.innerHTML = `Total Seats: ${totalSeats}<br>Valid Seats: ${validSeats}<br>Invalid Seats: ${invalidSeats}`;
                document.getElementById('totalSeats').value = totalSeats;
                document.getElementById('validSeats').value = validSeats;
                document.getElementById('invalidSeats').value = invalidSeats;
                document.getElementById('invalidSeatPositions').value = invalidSeatPositions.join(',');
            }
        }

        function saveSeats() {
            document.getElementById('seatForm').submit();
        }
    </script>
@endsection --}}

@extends('layouts/main')

@section('content')
    <h2>Add Seats</h2>
    <!-- Add your form and other content here -->
    <h1>เพิ่มที่นั่งในห้อง</h1>
    <form id="addSeatForm" method="POST" action="{{ route('examroominfo.store') }}" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
        @csrf
        <input type="hidden" name="building_th" value="{{ $buildingId }}">
        <input type="hidden" name="room_id" value="{{ $roomId }}">
        <input type="hidden" id="validSeatsInput" name="valid_seats">
        <input type="hidden" id="totalSeatsInput" name="total_seats">
        <input type="hidden" id="invalidSeatsInput" name="invalid_seats">
        <input type="hidden" id="invalidSeatPositionsInput" name="invalid_seat_positions">
        
        <!-- Input fields for row and column numbers -->
        <div class="row">
            <label for="rows">Rows:</label>
            <input type="number" id="rows" name="rows" min="1" required>
        </div>
        <div class="row">
            <label for="columns">Columns:</label>
            <input type="number" id="columns" name="columns" min="1" required>
        </div>

        <!-- Container for seats -->
        <div id="seat-container" style="display: flex; flex-wrap: wrap;"></div>

        <!-- Information about total seats and invalid seats -->
        <div id="seat-info"></div>

        <!-- Button to add seats -->
        <button type="button" onclick="addSeats()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Add Seats</button>
        
        <!-- Save button -->
        <button type="button" onclick="saveSeats()" style="background-color: #0000FF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Save</button>
    </form>

    <script>
        function addSeats() {
            const rows = document.getElementById('rows').value;
            const columns = document.getElementById('columns').value;
            const container = document.getElementById('seat-container');
            const seatInfo = document.getElementById('seat-info');
            container.innerHTML = ''; // Clear previous seats

            let totalSeats = 0;
            let invalidSeats = 0;
            let invalidSeatPositions = [];
            
            for (let row = 1; row <= rows; row++) {
                for (let col = 1; col <= columns; col++) {
                    const seatNumber = `${row}-${col}`;
                    const newSeat = document.createElement('div');
                    newSeat.className = 'seat';
                    newSeat.style.backgroundColor = 'green';
                    newSeat.style.width = '50px'; // Adjust width as needed
                    newSeat.style.height = '50px'; // Adjust height as needed
                    newSeat.style.margin = '5px'; // Adjust margin as needed
                    newSeat.innerText = seatNumber;
                    newSeat.addEventListener('click', function() {
                        if (newSeat.style.backgroundColor === 'green') {
                            newSeat.style.backgroundColor = 'red';
                            invalidSeats++;
                            invalidSeatPositions.push(seatNumber);
                        } else {
                            newSeat.style.backgroundColor = 'green';
                            invalidSeats--;
                            const index = invalidSeatPositions.indexOf(seatNumber);
                            if (index > -1) {
                                invalidSeatPositions.splice(index, 1);
                            }
                        }
                        updateSeatInfo();
                    });
                    container.appendChild(newSeat);

                    totalSeats++;
                }
            }

            // Display total seats, valid seats, and invalid seats information
            updateSeatInfo();

            function updateSeatInfo() {
                const validSeats = totalSeats - invalidSeats;
                seatInfo.innerHTML = `Total Seats: ${totalSeats}<br>Valid Seats: ${validSeats}<br>Invalid Seats: ${invalidSeats}`;
            }
        }

        function saveSeats() {
            // Update input fields with seat information
            document.getElementById('validSeatsInput').value = totalSeats - invalidSeats;
            document.getElementById('totalSeatsInput').value = totalSeats;
            document.getElementById('invalidSeatsInput').value = invalidSeats;
            document.getElementById('invalidSeatPositionsInput').value = JSON.stringify(invalidSeatPositions);

            // Submit the form
            document.getElementById('addSeatForm').submit();
            // Navigate to the addinfo page
            window.location.href = "{{ route('buildings.addinfo', ['buildingId' => $buildingId]) }}";
        }
    </script>
@endsection
