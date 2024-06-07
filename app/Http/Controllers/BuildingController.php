<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function create()
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/add', 'title' => 'สร้างอาคารสอบ'],
        ];

        return view('pages.building-create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'building_th' => 'required|string',
            'building_en' => 'required|string',
            'building_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('building_image')) {
            $fileName = $validatedData['building_en'] . '.' . $request->file('building_image')->getClientOriginalExtension();
            $imagePath = $request->file('building_image')->storeAs('building_images', $fileName, 'public');
            $imageFilename = basename($imagePath);
        } else {
            $imageFilename = null; 
        }
    
        $building = Building::create([
            'building_th' => $validatedData['building_th'],
            'building_en' => $validatedData['building_en'],
            'building_image' => $imageFilename,
        ]);
    
        return redirect()->route('buildings.addinfo', ['buildingId' => $building->id]);
    }

    public function index()
    {
        $buildings = Building::all();

        return view('buildings.index', compact('buildings'));
    }

    public function building_list()
    {
        $buildings = Building::all();
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
        ];

        return view('pages.building-list', compact('breadcrumbs', 'buildings'));
    }

    public function destroy($buildingId)
    {

        $building = Building::find($buildingId);

        if ($building) {

            ExamRoomInformation::where('building_code', $buildingId)->delete();

            $building->delete();

            return response()->json(['success' => true, 'message' => 'Building and associated exam room information deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Building not found.'], 404);
        }
    }

    public function edit($buildingId)
    {
        $building = Building::with('examRoomInformation')->find($buildingId);
        if (!$building) {
            return redirect()->route('buildings.index')->with('error', 'Building not found.');
        }

        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/'.$buildingId, 'title' => ''.$building->building_th], 
            ['url' => '/buildings/'.$buildingId.'/edit', 'title' => 'แก้ไขข้อมูล'],
        ];

        return view('buildings.edit', compact('building', 'breadcrumbs'));
    }

    public function update(Request $request, $buildingId)
    {
        $request->validate([
            'building_th' => 'required|string|max:255',
            'building_en' => 'required|string|max:255',
            // Add validation for other fields as needed
        ]);

        $building = Building::find($buildingId);
        if (!$building) {
            return redirect()->route('buildings.index')->with('error', 'Building not found.');
        }

        $building->update($request->all());

        // Update or create exam room information
        foreach ($request->exam_rooms as $examRoom) {
            ExamRoomInformation::updateOrCreate(
                ['building_code' => $buildingId, 'room' => $examRoom['room']],
                $examRoom
            );
        }

        return redirect()->route('building-list')->with('success', 'Building updated successfully.');
    }
}