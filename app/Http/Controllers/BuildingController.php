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

        return view('pages.room-manage.buildings.building-create', compact('breadcrumbs'));
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
            Log::info('Image Path: ' . $imagePath);
            Log::info('Image Filename: ' . $imageFilename);
        } else {
            $imageFilename = null;
            Log::info('No image uploaded.');
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
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
        ];
        session()->flash('sidebar', '2');

        return view('pages.room-manage.buildings.building-list', compact('breadcrumbs', 'buildings'));
    }

    public function destroy($buildingId)
    {
        $building = Building::find($buildingId);
    
        if ($building) {

            ExamRoomInformation::where('building_code', $buildingId)->delete();
    
            if ($building->building_image) {
                $imagePath = 'building_images/' . $building->building_image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $building->delete();
    
            return response()->json(['success' => true, 'message' => 'Building and associated exam room information deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Building not found.'], 404);
        }
    }

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
    
        if ($request->building_th_edit !== $building->building_th || $request->building_en_edit !== $building->building_en) {
            // Check if the edited building names (Thai and English) already exist in other buildings
            $existingBuilding = Building::where('id', '!=', $buildingId)
                ->where(function ($query) use ($request) {
                    $query->where('building_th', $request->building_th_edit)
                        ->orWhere('building_en', $request->building_en_edit);
                })->exists();
    
            if ($existingBuilding) {
                return response()->json(['error' => 'ชื่อของอาคารสอบต้องไม่ซ้ำกัน!'], 422);
            }
        }
    
        $building->building_th = $request->building_th_edit;
        $building->building_en = $request->building_en_edit;
    
        if ($request->hasFile('building_image_edit')) {
            // Delete the old image if it exists
            if ($building->building_image) {
                Storage::disk('public')->delete('building_images/' . $building->building_image);
            }
            
            $fileName = $request->building_en_edit . '.' . $request->file('building_image_edit')->getClientOriginalExtension();
            $imagePath = $request->file('building_image_edit')->storeAs('building_images', $fileName, 'public');
            $building->building_image = basename($imagePath);
        }
    
        $building->save();
    
        return response()->json(['success' => 'ข้อมูลอาคารสอบถูกแก้ไข้เรียบร้อยแล้ว']);
    }

    public function showRoomList($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $nextRoomId = ExamRoomInformation::where('building_code', $buildingId)->latest()->first();
        // $latestRoomId = ExamRoomInformation::where('building_code', $buildingId)->max('id');
        // $nextRoomId = $latestRoomId + 1;
        $rooms = $building->examRoomInformation()->paginate(12);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => ''.$building->building_th],
        ];
    
        return view('pages.room-manage.rooms.room-list', compact('building', 'rooms','nextRoomId', 'breadcrumbs'));
    }

    public function alert()
    {
        return back()->with('status', 'Task status updated successfully!');
    }

    public function index()
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
        ];
        session()->flash('sidebar', '1');

        return view('pages.index', compact('breadcrumbs'));
    }

}