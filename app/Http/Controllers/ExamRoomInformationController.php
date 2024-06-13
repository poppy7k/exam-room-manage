<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamRoomInformationController extends Controller
{

    public function create($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => $building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list/add', 'title' => 'สร้างห้องสอบ'],  
        ];

        return view('pages.room-create', compact('building', 'breadcrumbs', 'buildingId'));
    }

    public function store(Request $request, $buildingId)
    {
        $request->validate([
            'floor' => 'required|integer|min:0',
            'room' => 'required|string',
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
        ]);

        $totalSeats = $request->rows * $request->columns;

        ExamRoomInformation::create([
            'floor' => $request->floor,
            'room' => $request->room,
            'total_seats' => $totalSeats,
            'valid_seats' => $totalSeats,
            'building_code' => $buildingId,
        ]);

        return redirect()->route('pages.room-list', ['buildingId' => $buildingId])->with('success', 'Room created successfully.');
    }

    public function updateRoom(Request $request, $roomId)
    {
        $request->validate([
            'floor_edit' => 'required|numeric|min:0|max:255',
            'room_edit' => 'required|string',
        ]);
    
        $room = ExamRoomInformation::find($roomId);
        if (!$room) {
            return response()->json(['error' => 'Room not found.'], 404);
        }
    
        $room->floor = $request->floor_edit;
        $room->room = $request->room_edit;
        $room->save();
    
        return response()->json(['success' => 'Room updated successfully.']);
    }

    public function destroy($roomId)
    {

        $room = ExamRoomInformation::find($roomId);

        if ($room) {

            $room->delete();

            return response()->json(['success' => true, 'message' => 'Room deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Room not found.'], 404);
        }
    }
}

