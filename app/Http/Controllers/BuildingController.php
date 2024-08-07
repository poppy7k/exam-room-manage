<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Controllers\NotificationController;

class BuildingController extends Controller
{
    protected $notifications;

    public function __construct(NotificationController $notifications)
    {
        $this->notifications = $notifications;
    }

    public function create()
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
            ['url' => '/buildings/add', 'title' => 'สร้างอาคารสอบ'],
        ];

        return view('pages.room-manage.buildings.building-create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'building_th' => 'required|string',
            'building_en' => 'nullable|string',
            'building_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'building_map_url' => 'nullable|url',
        ]);

        if (empty($validatedData['building_en'])) {
            $validatedData['building_en'] = 'default_building_en';
        }
    
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
            'building_map_url' => $validatedData['building_map_url'],
        ]);
    
        // alerts-box
        $this->notifications->success('สร้างอาคารสอบเสร็จสิ้น!');
        
        return redirect()->route('pages.room-list', ['buildingId' => $building->id])
                         ->with('buildingData', $building->toArray());
    }

    public function building_list(Request $request)
    {
        $sort = $request->get('sort', 'alphabet_th'); // Default sort by building_th
        $buildings = Building::query()
            ->select('buildings.*')
            ->selectSub(
                ExamRoomInformation::query()
                    ->selectRaw('SUM(valid_seat)')
                    ->whereColumn('building_id', 'buildings.id'),
                'total_valid_seats'
            );
    
        switch ($sort) {
            case 'alphabet_th':
                $buildings->orderBy('building_th');
                break;
            case 'alphabet_en':
                $buildings->orderBy('building_en');
                break;
            case 'seat_desc':
                $buildings->orderByDesc('total_valid_seats');
                break;
            case 'seat_asc':
                $buildings->orderBy('total_valid_seats');
                break;
            default:
                $buildings->orderBy('building_th');
        }
        $buildings = $buildings->paginate(8);
    
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

            ExamRoomInformation::where('building_id', $buildingId)->delete();
    
            if ($building->building_image) {
                $imagePath = 'building_images/' . $building->building_image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $building->delete();
            $this->notifications->success('ลบอาคารสอบสำเร็จ!', $building->building_th);
    
            return response()->json(['success' => true, 'message' => 'Building and associated exam room information deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Building not found.'], 404);
            $this->notifications->danger('ไม่พบอาคารที่คุณต้องการ!', $building->building_th);
        }
    }

    public function updateAjax(Request $request, $buildingId)
    {
        $request->validate([
            'building_th_edit' => 'required|string|max:255',
            'building_en_edit' => 'required|string|max:255',
            'building_image_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'building_map_url_edit' => 'nullable|url'
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
        $building->building_map_url = $request->building_map_url_edit;
    
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

    public function index()
    {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
        ];
        session()->flash('sidebar', '1');

        return view('pages.index', compact('breadcrumbs'));
    }

    public function setAlertMessage(Request $request)
    {
        // ตั้ง session flash message
        session()->flash('status', 'success');
        session()->flash('message', $request->message);
        
    }

}