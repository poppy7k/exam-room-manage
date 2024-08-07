<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ExamRoomInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\NotificationController;

class ExamRoomInformationController extends Controller
{
    protected $notifications;

    public function __construct(NotificationController $notifications)
    {
        $this->notifications = $notifications;
    }

    public function create($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => $building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list/add', 'title' => 'สร้างห้องสอบ'],  
        ];

        return view('pages.room-manage.rooms.room-create', compact('building', 'breadcrumbs', 'buildingId'));
    }

    public function store(Request $request, $buildingId)
    {
        $request->validate([
            'room_create_floor' => 'required|string',
            'room_create_room' => 'required|string',
            'room_create_rows' => 'required|integer|min:1',
            'room_create_columns' => 'required|integer|min:1',
        ]);

        $totalSeats = $request->room_create_rows * $request->room_create_columns;
        // Log::info('Rows: ' . $request->room_create_rows);
        // Log::info('Columns: ' . $request->room_create_columns);
        // Log::info('Total Seats: ' . $totalSeats);

        ExamRoomInformation::create([
            'floor' => $request->room_create_floor,
            'room' => $request->room_create_room,
            'rows' => $request->room_create_rows,
            'columns' => $request->room_create_columns,
            'valid_seat' => $totalSeats,
            'total_seat' => $totalSeats,
            'building_id' => $buildingId,
        ]);

        // Log::info('Rows1: ' . $request->rows);
        // Log::info('Columns1: ' . $request->columns);
        // Log::info('Total Seats1: ' . $totalSeats);

        $this->notifications->success('สร้างห้องสอบสำเร็จ!');

        return redirect()->route('pages.room-list', ['buildingId' => $buildingId])->with('success', 'Room created successfully.');
    }

    public function showRoomList($buildingId, Request $request)
    {
        $building = Building::findOrFail($buildingId);
        $nextRoomId = ExamRoomInformation::where('building_id', $buildingId)->latest()->first();
        $rooms = $building->examRoomInformation();

        $sort = $request->get('sort', 'room_name_asc');
        switch ($sort) {
            case 'room_name_asc':
                $rooms = $rooms->orderBy('room');
                break;
            case 'room_name_desc':
                $rooms = $rooms->orderByDesc('room');
                break;
            default:
                $rooms = $rooms->orderBy('room');
        }

        $rooms = $rooms->paginate(12);

        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => ''.$building->building_th],
        ];

        session()->flash('sidebar', '2');
    
        return view('pages.room-manage.rooms.room-list', compact('building', 'rooms','nextRoomId', 'breadcrumbs'));
    }

    public function updateRoom(Request $request, $roomId)
    {
        $request->validate([
            'floor_edit' => 'required|string',
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
            $this->notifications->success('ลบห้องสอบสำเร็จ!', $room->room);

            return response()->json(['success' => true, 'message' => 'Room deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Room not found.'], 404);
        }
    }

    public function showRoomDetail($buildingId, $roomId)
    {
        $building = Building::findOrFail($buildingId);
        $room = ExamRoomInformation::findOrFail($roomId);
        $invalidSeats = json_encode($room->invalid_seats);
        // Log::info('$selectedSeats: ' . $selectedSeats);
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/buildings', 'title' => 'รายการอาคารสอบ'],
            ['url' => '/buildings/'.$buildingId.'/room-list', 'title' => $building->building_th],
            ['url' => '/buildings/'.$buildingId.'/room-list/'.$roomId, 'title' => $room->room],  
        ];
        session()->flash('sidebar', '2');
    
        return view('pages.room-manage.rooms.room-detail', [
            'buildingId' => $buildingId,
            'roomId' => $roomId,
            'breadcrumbs' => $breadcrumbs,
            'room' => $room,
            'invalidSeats' => $invalidSeats,
        ]);
    }

    public function saveInvalidSeats(Request $request, $buildingId, $roomId)
    {
        $request->validate([
            'invalid_seats' => 'required|json',
            'valid_seat' => 'required|integer',
            'rows' => 'required|integer',
            'columns' => 'required|integer',
        ]);
    
        $room = ExamRoomInformation::where('building_id', $buildingId)
                                    ->where('id', $roomId)
                                    ->firstOrFail();
    
        $room->invalid_seats = $request->invalid_seats;
        $room->valid_seat = $request->valid_seat;
        $room->rows = $request->rows;
        $room->columns = $request->columns;
        $room->total_seat = $request->rows * $request->columns;
        $room->save();

        $this->notifications->success('บันทึกผังห้องสำเร็จ!', $room->room);
    
        return redirect()->route('pages.room-list', ['buildingId' => $buildingId])
                         ->with('success', 'Selected seats saved successfully.');
    }
    
}



