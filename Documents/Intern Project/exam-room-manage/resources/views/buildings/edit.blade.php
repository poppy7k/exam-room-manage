@extends('layouts/main')

@section('content')
<div class="container mt-24 ml-8 mb-24 lg:ml-80 2xl:pl-24">
    <h2 class="text-2xl font-semibold mb-6">Edit Building</h2>
    <form action="{{ route('buildings.update', $building->id) }}" method="POST" enctype="multipart/form-data" style="width: 100%; max-width: 600px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <!-- Building Name Fields -->
        <div class="mb-4">
            <label for="building_th" class="block text-gray-700">Building Name (TH):</label>
            <input type="text" id="building_th" name="building_th" value="{{ $building->building_th }}" class="mt-1 block w-full" required style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        </div>
        <div class="mb-4">
            <label for="building_en" class="block text-gray-700">Building Name (EN):</label>
            <input type="text" id="building_en" name="building_en" value="{{ $building->building_en }}" class="mt-1 block w-full" required style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        </div>

        <!-- Exam Room Information -->
        <h3 class="text-xl font-semibold mb-4">Exam Room Information</h3>

        <div id="exam-rooms">
            @foreach ($building->examRoomInformation as $examRoom)
                <div class="mb-4 exam-room" style="border: 1px solid #ccc; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
                    <!-- Floor -->
                    <label for="floor_{{ $examRoom->id }}" class="block text-gray-700">Floor:</label>
                    <input type="text" id="floor_{{ $examRoom->id }}" name="exam_rooms[{{ $examRoom->id }}][floor]" value="{{ $examRoom->floor }}" class="mt-1 block w-full" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        
                    <!-- Room Name -->
                    <label for="room_{{ $examRoom->id }}" class="block text-gray-700">Room Name:</label>
                    <input type="text" id="room_{{ $examRoom->id }}" name="exam_rooms[{{ $examRoom->id }}][room]" value="{{ $examRoom->room }}" class="mt-1 block w-full" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        
                    <!-- Valid Seat -->
                    <label for="valid_seat_{{ $examRoom->id }}" class="block text-gray-700">Valid Seat:</label>
                    <input type="number" id="valid_seat_{{ $examRoom->id }}" name="exam_rooms[{{ $examRoom->id }}][valid_seat]" value="{{ $examRoom->valid_seat }}" class="mt-1 block w-full" required min=0 style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        
                    <!-- Total Seat -->
                    <label for="total_seat_{{ $examRoom->id }}" class="block text-gray-700">Total Seat:</label>
                    <input type="number" id="total_seat_{{ $examRoom->id }}" name="exam_rooms[{{ $examRoom->id }}][total_seat]" value="{{ $examRoom->total_seat }}" class="mt-1 block w-full" required min=0 style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; margin-bottom: 1rem;">
        
        
                    <button type="button" class="mt-2 text-red-500" onclick="removeExamRoom(this)">Remove Room</button>
                </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">Update Building</button>
        </div>
    </form>
</div>

<script>
    function removeExamRoom(button) {
        button.parentElement.remove();
    }
</script>
@endsection