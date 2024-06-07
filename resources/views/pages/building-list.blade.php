@extends('layouts.main')

@section('content')
<div class="flex flex-col divide-y z-20 container mt-24 ml-8 mb-24 lg:ml-80 w-full">
    <div class="flex justify-between items-center">
        <p class="font-semibold text-2xl justify-start">
            อาคารสอบทั้งหมด
        </p>
        <x-buttons.icon-primary type="submit" route="{{ route('buildings.addbuilding') }}" class="px-1 py-1 z-40">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16" height="16"><g><path d="M480,224H288V32c0-17.673-14.327-32-32-32s-32,14.327-32,32v192H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h192v192   c0,17.673,14.327,32,32,32s32-14.327,32-32V288h192c17.673,0,32-14.327,32-32S497.673,224,480,224z"/></g>/</svg>
            <x-tooltip title="เพิ่มอาคาร" class="group-hover:-translate-x-7"></x-tooltip>
        </x-buttons.icon-primary>
    </div>
    <div class="grid 2xl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-2">
        @foreach ($buildings as $building)
            <x-building-card
                :building_image="'https://images.unsplash.com/photo-1554629947-334ff61d85dc?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1024&h=1280&q=80'"
                :building_th="$building->building_th"
                :building_en="$building->building_en"
                :building_id="$building->id"
            />
        @endforeach
    </div>
</div>
@endsection
