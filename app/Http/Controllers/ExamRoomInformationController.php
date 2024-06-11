<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;

class ExamRoomInformationController extends Controller
{
    public function create($buildingId)
    {
        $buildingData = session('buildingData');
    
        if (!$buildingData) {
            return redirect()->route('buildings.create')->with('error', 'No building data found. Please create a building first.');
        }
    
        return view('pages.addinfo', ['buildingData' => $buildingData, 'buildingId' => $buildingId]);
    }

    public function store(Request $request, $buildingId)
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'อาคารสอบ'],
            ['url' => "/buildings/add", 'title' => 'สร้างอาคารสอบ'],
            ['url' => "/buildings/{$buildingId}/addinfo", 'title' => "ข้อมูลอาคาร {$buildingId}"]
        ];
    
        session(['breadcrumbs' => $breadcrumbs]);
    
        $validatedData = $request->validate([
            'building_th' => 'required|string',
            'building_en' => 'required|string',
            'building_image' => 'nullable|string',
            'rooms' => 'required|array',
            'rooms.*.floor' => 'required|string',
            'rooms.*.room' => 'required|string',
            'rooms.*.total_seat' => 'required|integer',
            'rooms.*.valid_seat' => 'required|integer',
        ]);
    
        $building = Building::create([
            'building_th' => $validatedData['building_th'],
            'building_en' => $validatedData['building_en'],
            'building_image' => $validatedData['building_image'],
        ]);
    
        foreach ($validatedData['rooms'] as $roomData) {
            ExamRoomInformation::create([
                'building_code' => $building->id,
                'floor' => $roomData['floor'],
                'room' => $roomData['room'],
                'total_seat' => $roomData['total_seat'],
                'valid_seat' => $roomData['valid_seat'],
            ]);
        }
    
        return redirect()->route('building-list')->with('success', 'Building and exam room information have been saved.');
    }

    public function addSeat($buildingId, $roomId)
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'อาคารสอบ'],
            ['url' => "/buildings/add", 'title' => 'สร้างอาคารสอบ'],
            ['url' => "/buildings/{$buildingId}/addinfo", 'title' => "ข้อมูลอาคาร {$buildingId}"],
            ['url' => '', 'title' => "เพิ่มที่นั่งในห้อง {$roomId}"]
        ];
    
        return view('buildings.add-seat', [
            'buildingId' => $buildingId,
            'roomId' => $roomId,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    // public function addSeat($buildingId, $roomId)
    // {
    //     $building = Building::findOrFail($buildingId);
    //     $breadcrumbs = [
    //         ['url' => '/', 'title' => 'หน้าหลัก'],
    //         ['url' => '/buildings', 'title' => 'อาคารสอบ'],
    //         ['url' => "/buildings/add", 'title' => 'สร้างอาคารสอบ'],
    //         ['url' => "/buildings/{$buildingId}/addinfo", 'title' => "ข้อมูลอาคาร {$building->$buildingId}"],
    //         ['url' => '', 'title' => "เพิ่มที่นั่งในห้อง {$roomId}"]
    //     ];
    
    //     return view('buildings.add-seat', [
    //         'buildingId' => $buildingId,
    //         'roomId' => $roomId,
    //         'breadcrumbs' => $breadcrumbs
    //     ]);
    // }
    public function updateRoom(Request $request, $roomId)
    {
        $request->validate([
            'floor' => 'required|string|max:255',
            'room' => 'required|string|max:255',
        ]);
    
        $room = ExamRoomInformation::find($roomId);
        if (!$room) {
            return response()->json(['error' => 'Room not found.'], 404);
        }
    
        $room->floor = $request->floor;
        $room->room = $request->room;
        $room->save();
    
        return response()->json(['success' => 'Room updated successfully.']);
    }
}

