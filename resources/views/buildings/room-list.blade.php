@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-semibold mb-4">{{ $building->building_th }} - Room List</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($rooms as $room)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold">{{ $room->room }}</h3>
                    <p class="text-gray-600">Floor: {{ $room->floor }}</p>
                    <p class="text-gray-600">Valid Seat: {{ $room->valid_seat }}</p>
                    <p class="text-gray-600">Total Seat: {{ $room->total_seat }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection