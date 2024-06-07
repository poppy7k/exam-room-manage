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
        return view('buildings.addbuilding');
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

        return view('pages.building-list', compact('buildings'));
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
}