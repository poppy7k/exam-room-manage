<form method="POST" action="{{ route('examroominfo.store') }}" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    @csrf

    <input type="hidden" name="building_code" value="{{ $buildingId }}">

    <div id="room-container">
        <div class="room-group" style="margin-bottom: 20px;">
            <label for="floor" style="display: block; font-weight: bold; margin-bottom: 5px;">Floor</label>
            <input type="text" name="rooms[0][floor]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="room" style="display: block; font-weight: bold; margin-bottom: 5px;">Room</label>
            <input type="text" name="rooms[0][room]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="total_seat" style="display: block; font-weight: bold; margin-bottom: 5px;">Total Seats</label>
            <input type="number" name="rooms[0][total_seat]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="valid_seat" style="display: block; font-weight: bold; margin-bottom: 5px;">Valid Seats</label>
            <input type="number" name="rooms[0][valid_seat]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <button type="button" onclick="removeRoom(this)" style="background-color: #FF0000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Remove</button>
        </div>
    </div>

    <button type="button" onclick="addRoom()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Add</button>
    <button type="submit" style="background-color: #0000FF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Submit</button>
</form>

<script>
    let roomIndex = 1;

    function addRoom() {
        const container = document.getElementById('room-container');
        const newRoom = document.createElement('div');
        newRoom.className = 'room-group';
        newRoom.style.marginBottom = '20px';
        newRoom.innerHTML = `
            <label for="floor" style="display: block; font-weight: bold; margin-bottom: 5px;">Floor</label>
            <input type="text" name="rooms[${roomIndex}][floor]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="room" style="display: block; font-weight: bold; margin-bottom: 5px;">Room</label>
            <input type="text" name="rooms[${roomIndex}][room]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="total_seat" style="display: block; font-weight: bold; margin-bottom: 5px;">Total Seats</label>
            <input type="number" name="rooms[${roomIndex}][total_seat]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="valid_seat" style="display: block; font-weight: bold; margin-bottom: 5px;">Valid Seats</label>
            <input type="number" name="rooms[${roomIndex}][valid_seat]" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <button type="button" onclick="removeRoom(this)" style="background-color: #FF0000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Remove</button>
        `;
        container.appendChild(newRoom);
        roomIndex++;
    }

    function removeRoom(button) {
        button.parentElement.remove();
    }
</script>