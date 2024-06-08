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
        return view('buildings.addinfo', ['buildingId' => $buildingId]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'building_code' => 'required|exists:buildings,id',
            'rooms' => 'required|array',
            'rooms.*.floor' => 'required|string',
            'rooms.*.room' => 'required|string',
            'rooms.*.total_seat' => 'required|integer',
            'rooms.*.valid_seat' => 'required|integer',
        ]);

        foreach ($validatedData['rooms'] as $roomData) {
            ExamRoomInformation::create([
                'building_code' => $validatedData['building_code'],
                'floor' => $roomData['floor'],
                'room' => $roomData['room'],
                'total_seat' => $roomData['total_seat'],
                'valid_seat' => $roomData['valid_seat'],
            ]);
        }

        return redirect()->route('buildings.index')->with('success', 'Exam room information has been saved.');
    }
}
// namespace App\Http\Controllers;

// use App\Models\Building;
// use App\Models\ExamRoomInformation;
// use Illuminate\Http\Request;

// class ExamRoomInformationController extends Controller
// {
//     public function create($buildingId)
//     {
//         $building = Building::findOrFail($buildingId);
//         return view('buildings.addinfo', ['buildingId' => $buildingId, 'building' => $building]);
//     }
//     // public function create($buildingId)
//     // {
//     //     $building = Building::findOrFail($buildingId);
//     //     return view('buildings.addinfo', compact('buildingId', 'building'));
//     // }

//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'building_code' => 'required|exists:buildings,id',
//             'rooms' => 'required|array',
//             'rooms.*.floor' => 'required|string',
//             'rooms.*.room' => 'required|string',
//             'rooms.*.total_seat' => 'required|integer',
//             'rooms.*.valid_seat' => 'required|integer',
//         ]);

//         foreach ($validatedData['rooms'] as $roomData) {
//             ExamRoomInformation::create([
//                 'building_code' => $validatedData['building_code'],
//                 'floor' => $roomData['floor'],
//                 'room' => $roomData['room'],
//                 'total_seat' => $roomData['total_seat'],
//                 'valid_seat' => $roomData['valid_seat'],
//             ]);
//         }

//         return redirect()->route('buildings.index')->with('success', 'Exam room information has been saved.');
//     }
// }