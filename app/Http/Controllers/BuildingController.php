<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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

        // alerts-box
        session()->flash('status', 'success');
        session()->flash('message', 'สร้างอาคารสอบสำเร็จ!');
    
        return redirect()->route('pages.room-list', ['buildingId' => $building->id])
                         ->with('buildingData', $building->toArray());
    }

    public function building_list()
    {
        $buildings = Building::paginate(8);
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

    // public function update(Request $request, $buildingId)
    // {
    //     $request->validate([
    //         'building_th' => 'required|string|max:255',
    //         'building_en' => 'required|string|max:255',
    //     ]);

    //     $building = Building::find($buildingId);
    //     if (!$building) {
    //         return redirect()->route('buildings.index')->with('error', 'Building not found.');
    //     }

    //     $building->update($request->all());

    //     foreach ($request->exam_rooms as $examRoom) {
    //         ExamRoomInformation::updateOrCreate(
    //             ['building_code' => $buildingId, 'room' => $examRoom['room']],
    //             $examRoom
    //         );
    //     }
    //     return redirect()->route('building-list')->with('success', 'Building updated successfully.');
    // }

    public function updateAjax(Request $request, $buildingId)
    {
        $request->validate([
            'building_th_edit' => 'required|string|max:255',
            'building_en_edit' => 'required|string|max:255',
            'building_image_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $building = Building::find($buildingId);
        if (!$building) {
            return response()->json(['error' => 'Building not found.'], 404);
        }

        $existingBuilding = Building::where('building_th', $request->building_th_edit)
                                    ->orWhere('building_en', $request->building_en_edit)
                                    ->where('id', '<>', $buildingId)
                                    ->first();
        if ($existingBuilding) {
            // alerts-box
            //session()->flash('status', 'failed');
            //session()->flash('message', 'ชื่ออาคารซ้ำ!');
            return response()->json(['error' => 'Building name already exists.'], 422);
        }

    
        $building->building_th = $request->building_th_edit;
        $building->building_en = $request->building_en_edit;
    
        if ($request->hasFile('building_image_edit')) {
            $fileName = $request->building_en . '.' . $request->file('building_image_edit')->getClientOriginalExtension();
            $imagePath = $request->file('building_image_edit')->storeAs('building_image_edit', $fileName, 'public');
            $building->building_image = basename($imagePath);
        }
    
        $building->save();
    
        return response()->json(['success' => 'Building updated successfully.']);
    }

    // public function updateAjax(Request $request, $buildingId)
    // {
    //     try {
    //         Log::info('Update Building Request Data:', $request->all());

    //         $building = Building::findOrFail($buildingId);
    //         $building->building_th = $request->input('building_th_edit');
    //         $building->building_en = $request->input('building_en_edit');

    //         Log::info('Building EN:', ['building_en' => $request->input('building_en_edit')]);

    //         if ($request->hasFile('building_image_edit')) {
    //             $path = $request->file('building_image_edit')->store('building_images', 'public');
    //             $building->image_path = $path;
    //         }

    //         $building->save();

    //         return response()->json(['success' => 'Building updated successfully.']);
    //     } catch (\Exception $e) {
    //         Log::error('Failed to update building:', ['error' => $e->getMessage()]);
    //         return response()->json(['error' => 'Failed to update the building.'], 500);
    //     }
    // }

    public function showRoomList($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $nextRoomId = ExamRoomInformation::where('building_code', $buildingId)->latest()->first();
        // $latestRoomId = ExamRoomInformation::where('building_code', $buildingId)->max('id');
        // $nextRoomId = $latestRoomId + 1;
        $rooms = $building->examRoomInformation()->paginate(12);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => ''.$building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => 'รายการห้องสอบ'], 
        ];
    
        return view('pages.room-list', compact('building', 'rooms','nextRoomId', 'breadcrumbs'));
    }

    public function alert()
    {
        return back()->with('status', 'Task status updated successfully!');
    }

}