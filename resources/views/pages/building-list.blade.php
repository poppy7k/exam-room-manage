@extends('layouts/main')

@section('content')
<div class="flex flex-col divide-y z-20 container mt-24 ml-8 mb-24 lg:ml-80 2xl:pl-24 ">
    <p class="font-semibold text-2xl">
        อาคารสอบทั้งหมด
    </p>
    <div class="grid 2xl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-2">
        @foreach ($buildings as $building)
            <x-building-card
                :building_image="file_exists('storage/' . $building->building_image) ? asset('storage/' . $building->building_image) : $building->building_image"
                :building_th="$building->building_th"
                :building_en="$building->building_en"
            />
        @endforeach
    </div>
</div>
@endsection