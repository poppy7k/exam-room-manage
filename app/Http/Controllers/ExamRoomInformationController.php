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
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => 'รายการห้องสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list/add', 'title' => 'เพิ่มห้องสอบ'],  
        ];

        return view('pages.room-create', compact('building', 'breadcrumbs', 'buildingId'));
    }

    public function store(Request $request, $buildingId)
    {
        $request->validate([
            'floor' => 'required|string',
            'room' => 'required|string',
            'rows' => 'required|integer|min:1',
            'columns' => 'required|integer|min:1',
        ]);

        $totalSeats = $request->rows * $request->columns;
        Log::info('Rows: ' . $request->rows);
        Log::info('Columns: ' . $request->columns);
        Log::info('Total Seats: ' . $totalSeats);

        ExamRoomInformation::create([
            'floor' => $request->floor,
            'room' => $request->room,
            'rows' => $request->rows,
            'columns' => $request->columns,
            'valid_seats' => $totalSeats,
            'total_seats' => $totalSeats,
            'building_code' => $buildingId,
        ]);

        Log::info('Rows1: ' . $request->rows);
        Log::info('Columns1: ' . $request->columns);
        Log::info('Total Seats1: ' . $totalSeats);

        return redirect()->route('pages.room-list', ['buildingId' => $buildingId])->with('success', 'Room created successfully.');
    }

    public function updateRoom(Request $request, $roomId)
    {
        $request->validate([
            'floor_edit' => 'required|numeric|min:0|max:255',
            'room_edit' => 'required|numeric|min:0|max:255',
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
    public function showRoomDetail($buildingId, $roomId)
    {
        $building = Building::findOrFail($buildingId);
        $room = ExamRoomInformation::findOrFail($roomId);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => $building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => 'รายการห้องสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list/'.$roomId, 'title' => $room->room],  
        ];

        return view('pages.room-detail', [
            'buildingId' => $buildingId,
            'roomId' => $roomId,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}



