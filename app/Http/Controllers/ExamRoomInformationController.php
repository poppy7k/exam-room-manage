<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;

class ExamRoomInformationController extends Controller
{

    public function create($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        // $room = ExamRoomInformation::findOrFail($roomId);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => ''.$building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => 'รายการห้องสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list'.'/add', 'title' => 'เพิ่มห้องสอบ'],  
        ];

        return view('pages.room-create', compact('building','breadcrumbs'));
    }

    public function store(Request $request, $buildingId , $roomId)
    {
        $request->validate([
            'floor' => 'required|string',
            'room' => 'required|string',
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
            'invalid_seats' => 'required|integer|min:0',
        ]);

        $totalSeats = $request->rows * $request->columns;

        ExamRoomInformation::create([
            'floor' => $request->floor,
            'room' => $request->room,
            'total_seats' => $totalSeats,
            'invalid_seats' => $request->invalid_seats,
            'building_code' => $buildingId,
            'id' => $roomId,
        ]);

        return redirect()->route('pages.room-list', ['building' => $buildingId, 'room' => $roomId])->with('success', 'Room created successfully.');
    }

    // public function addSeat($buildingId, $roomId)
    // {
    //     $breadcrumbs = [
    //         ['url' => '/', 'title' => 'หน้าหลัก'],
    //         ['url' => '/buildings', 'title' => 'อาคารสอบ'],
    //         ['url' => "/buildings/add", 'title' => 'สร้างอาคารสอบ'],
    //         ['url' => "/buildings/{$buildingId}/addinfo", 'title' => "ข้อมูลอาคาร {$buildingId}"],
    //         ['url' => '', 'title' => "เพิ่มที่นั่งในห้อง {$roomId}"]
    //     ];
    
    //     return view('buildings.add-seat', [
    //         'buildingId' => $buildingId,
    //         'roomId' => $roomId,
    //         'breadcrumbs' => $breadcrumbs
    //     ]);
    // }
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

