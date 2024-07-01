<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Building;
use App\Models\Applicant;
use App\Models\ExamRoomInformation;
use App\Models\SelectedRoom;
use App\Models\Seat;
use App\Models\Staff;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    protected $staffController;
    protected $seatController;

    public function __construct(StaffController $staffController, SeatController $seatController)
    {
        $this->staffController = $staffController;
        $this->seatController = $seatController;
    }

    public function index() {
        $exams = Exam::paginate(8);
        $totalExams = $exams->total();
        $departments = Applicant::pluck('department');
        $positions = Applicant::pluck('position');
        $applicants = Applicant::all();
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
        ];
        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-list', compact('breadcrumbs','exams','departments', 'positions','applicants', 'totalExams'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_name' => 'required|string',
            'exam_position' => 'required|string',
            'exam_date' => 'required|date',
            'exam_start_time' => 'required|date_format:H:i',
            'exam_end_time' => 'required|date_format:H:i',
            'subject' => 'required|string',
        ]);
        $organizations = ["สำนักกองบริหารกลาง"];
        $randomOrganization = $organizations[array_rand($organizations)];
        $applicantCount = Applicant::where('department', $validatedData['department_name'])
                                ->where('position', $validatedData['exam_position'])
                                ->count();
    
        $exam = Exam::create([
            'department_name' => $validatedData['department_name'],
            'exam_position' => $validatedData['exam_position'],
            'exam_date' => $validatedData['exam_date'],
            'exam_start_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_start_time'],
            'exam_end_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_end_time'],
            'organization' => $randomOrganization,
            'exam_takers_quantity' => $applicantCount,
            'status' => 'pending',
            'subject' => $validatedData['subject'],
        ]);

        session()->flash('status', 'success');
        session()->flash('message', 'สร้างการสอบสำเร็จ!');
    
        return redirect()->route('exam-list');
    }
    
    public function create() {
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams', 'title' => 'สร้างการสอบ'],
        ];

        $departments = Applicant::pluck('department');
        $positions = Applicant::pluck('position');
        $applicants = Applicant::all();

        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-create', compact('breadcrumbs', 'departments', 'positions','applicants'));
    }

    public function destroy($examId)
    {
        $exam = Exam::find($examId);
    
        if ($exam) {
            $exam->delete();
            return response()->json(['success' => true, 'message' => 'Exam and associated seats deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Exam not found.'], 404);
        }
    }    

    public function showExamBuildingList($examId, Request $request)
    {
        $exams = Exam::findOrFail($examId);
        $sort = $request->get('sort', 'alphabet_th'); // Default sort by building_th
        $buildings = Building::query()
            ->select('buildings.*')
            ->selectSub(
                ExamRoomInformation::query()
                    ->selectRaw('SUM(valid_seat) - COALESCE(SUM(selected_rooms.applicant_seat_quantity), 0) as total_valid_seats')
                    ->leftJoin('selected_rooms', function($join) use ($exams) {
                        $join->on('exam_room_information.id', '=', 'selected_rooms.room_id')
                            ->leftJoin('exams', 'selected_rooms.exam_id', '=', 'exams.id')
                            ->where('exams.exam_date', $exams->exam_date)
                            ->where('exams.exam_start_time', '<', $exams->exam_end_time)
                            ->where('exams.exam_end_time', '>', $exams->exam_start_time);
                    })
                    ->whereColumn('exam_room_information.building_id', 'buildings.id'),
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
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => ''.$exams->department_name],
        ];
        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-buildinglist', compact('breadcrumbs', 'exams','buildings'));
    }
    
    public function showExamRoomList($examId, $buildingId, Request $request)
    {
        $exams = Exam::findOrFail($examId);
        $buildings = Building::findOrFail($buildingId);
        $roomsQuery = $buildings->examRoomInformation();
    
        $sort = $request->get('sort', 'room_name_asc');
        switch ($sort) {
            case 'room_name_asc':
                $roomsQuery = $roomsQuery->orderBy('room');
                break;
            case 'room_name_desc':
                $roomsQuery = $roomsQuery->orderByDesc('room');
                break;
            default:
                $roomsQuery = $roomsQuery->orderBy('room');
        }
    
        $rooms = $roomsQuery->paginate(12);
        $totalRoom = $rooms->total();
    
        $selectedRooms = SelectedRoom::where('exam_id', $examId)->get()->keyBy('room_id');
    
        $rooms->getCollection()->transform(function ($room) use ($selectedRooms, $exams) {
            $selectedRoom = SelectedRoom::join('exams', 'selected_rooms.exam_id', '=', 'exams.id')
                                        ->where('selected_rooms.room_id', $room->id)
                                        ->where('exams.exam_date', $exams->exam_date)
                                        ->where(function($query) use ($exams) {
                                            $query
                                                ->where('exams.exam_start_time', '<', $exams->exam_end_time)
                                                ->where('exams.exam_end_time', '>', $exams->exam_start_time);
                                        })
                                        ->first();
            $room->valid_seat = $selectedRoom ? $room->valid_seat - $selectedRoom->applicant_seat_quantity : $room->valid_seat;
            Log::info('Room ID: '.$room->id.' Exam Valid Seat: '.$room->valid_seat);
            return $room;
        });
        
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => $exams->department_name],
            ['url' => '/exams/'.$examId.'/buildings/'.$buildingId, 'title' => $buildings->building_th],
        ];
        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-roomlist', compact('breadcrumbs', 'exams', 'buildings', 'rooms', 'totalRoom'));
    }

    public function showExamRoomDetail($examId, $selectedRoomId)
    {
        $exam = Exam::findOrFail($examId);
        $selectedRooms = SelectedRoom::findOrFail($selectedRoomId);
        $room = ExamRoomInformation::findOrFail($selectedRooms->room_id);
        $building = $room->building;
    
        $seats = Seat::where('selected_room_id', $selectedRoomId)
                     ->get();
        // Log::info('Seats:', $seats->toArray());
    
        $applicants = Applicant::whereIn('id', $seats->pluck('applicant_id'))->get();
    
        $staffs = $selectedRooms ? $selectedRooms->staffs : collect();
    
        // Get all staff who are assigned to any room at the same time as this exam
        $assignedStaffs = Staff::whereHas('selectedRooms', function ($query) use ($exam) {
            $query->whereHas('exam', function($examQuery) use ($exam) {
                $examQuery->where('exam_date', $exam->exam_date)
                          ->where('exam_start_time', '<=', $exam->exam_end_time)
                          ->where('exam_end_time', '>=', $exam->exam_start_time);
            });
        })->get()->map(function ($staff) use ($exam) {
            return [
                'staff_id' => $staff->id,
                'name' => $staff->name,
                'exam_date' => $exam->exam_date,
                'exam_start_time' => $exam->exam_start_time,
                'exam_end_time' => $exam->exam_end_time,
                'exam_id' => $exam->id
            ];
        });
    
        //Log::info('Assigned Staffs Query Result: ', ['query' => $assignedStaffs->toArray()]);

        $departments = $applicants->pluck('department')->unique()->toArray();
        $positions = $applicants->pluck('position')->unique()->toArray();
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/selectedrooms', 'title' => ''.$exam->department_name],
            ['url' => '/exams/'.$examId.'/selectedrooms/'.$selectedRooms->room_id, 'title' => ''.$room->room],
        ];
    
        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-roomdetail', compact('selectedRooms','building','exam', 'room', 'breadcrumbs', 'applicants', 'staffs', 'seats', 'assignedStaffs','departments','positions'));
    }
    
    public function updateExamStatus(Request $request)
    {
        $validatedData = $request->validate([
            'exam_id' => 'required|integer|exists:exams,id',
            'selected_rooms' => 'required|string',
        ]);
    
        $exam = Exam::findOrFail($validatedData['exam_id']);
    
        if (is_null($exam->exam_date) || is_null($exam->exam_start_time) || is_null($exam->exam_end_time)) {
            return redirect()->back()->with('status', 'Exam date or time is missing');
        }
    
        $selectedRooms = json_decode($validatedData['selected_rooms'], true);
        // Log::info('Decoded Selected Rooms: ', $selectedRooms);
    
        SelectedRoom::where('exam_id', $exam->id)->delete();
    
        foreach ($selectedRooms as $roomData) {
            $examValidSeat = $roomData['usedSeat'];
            
            SelectedRoom::create([
                'exam_id' => $exam->id,
                'room_id' => $roomData['id'],
                'applicant_seat_quantity' => $examValidSeat,
            ]);
        }
    
        $this->staffController->duplicateStaffAssignments($exam);
    
        $conflictedApplicants = $this->seatController->assignApplicantsToSeats($exam->department_name, $exam->exam_position, $selectedRooms, $exam);
    
        if (count($conflictedApplicants) > 0) {
            return redirect()->back()->with('status', 'conflict')->with('conflictedApplicants', $conflictedApplicants);
        }
    
        $exam->status = 'ready';
        $exam->save();
    
        return redirect()->route('exam-list')->with('status', 'Exam updated to ready and rooms selected!');
    }
    
    public function getExam() {

        $exams = Exam::all();

        $events = $exams->map(function ($exam) {
            return [
                'title' => $exam->department_name, // ปรับตามชื่อฟิลด์ที่ต้องการแสดงเป็นชื่อของ event
                'start' => $exam->exam_date . 'T' . $exam->exam_start_time,
                'end' => $exam->exam_date . 'T' . $exam->exam_end_time,
            ];
        });

        return response()->json($exams);
    }  

    public function updateExam(Request $request)
    {
        // Log::info('Update exam request received', $request->all());
    
        try {
    
            $exam = Exam::findOrFail($request->exam_id);
    
            // Log::info('Exam found', ['exam' => $exam]);

            $applicantCount = Applicant::where('department', $request->department_name)
            ->where('position', $request->exam_position)
            ->count();
    
            $exam->update([
                'department_name' => $request->department_name,
                'exam_position' => $request->exam_position,
                'exam_date' => $request->exam_date,
                'exam_start_time' => $request->exam_date . ' ' . $request->exam_start_time,
                'exam_end_time' => $request->exam_date . ' ' . $request->exam_end_time,
                'exam_takers_quantity' => $applicantCount,
                'subject' => $request->subject,
            ]);
    
            // Log::info('Exam updated', ['exam' => $exam]);
    
            return redirect()->route('exam-list')->with('status', 'Exam updated successfully');
    
        } catch (\Exception $e) {
            Log::error('Error updating exam', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
    
            return redirect()->back()->withErrors(['error' => 'Failed to update exam. Please try again.']);
        }
    }
    
}
