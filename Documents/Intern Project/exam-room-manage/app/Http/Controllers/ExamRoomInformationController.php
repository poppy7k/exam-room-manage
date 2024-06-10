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
    
        return view('buildings.addinfo', ['buildingData' => $buildingData, 'buildingId' => $buildingId]);
    }

    public function store(Request $request)
    {
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
}
