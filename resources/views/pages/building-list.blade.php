@extends('layouts/main')

@section('content')
<div class="flex flex-col divide-y z-20 container mt-24 ml-8 mb-24">
    <p class="font-semibold text-2xl">
        อาคารสอบทั้งหมด
    </p>
    <div class="grid grid-cols-4 gap-4 mt-2">
        <div>
            @foreach ($buildings as $building)
            <li class="building-item" style="background: #ffffff; margin: 10px 0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">{{ $building->building_th }} ({{ $building->building_en }})</li>
            @endforeach
            
            @include('components/building-card')
        </div>
        <div>
            <p>1</p>
        </div>
        <div>
            <p>1</p>
        </div>
        <div>
            <p>1</p>
        </div>
        <div>
            <p>1</p>
        </div>
    </div>
</div>
@endsection