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

class ExamController extends Controller
{
    public function index() {
        $exams = Exam::paginate(8);
        $departments = Applicant::pluck('department');
        $positions = Applicant::pluck('position');
        $applicants = Applicant::all();
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
        ];
        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-list', compact('breadcrumbs','exams','departments', 'positions','applicants'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_name' => 'required|string',
            'exam_position' => 'required|string',
            'exam_date' => 'required|date',
            'exam_start_time' => 'required|date_format:H:i',
            'exam_end_time' => 'required|date_format:H:i',
        ]);
        $organizations = ["สำนักกองบริหารกลาง"];
        $randomOrganization = $organizations[array_rand($organizations)];
        $applicantCount = Applicant::where('department', $validatedData['department_name'])
                                ->where('position', $validatedData['exam_position'])
                                ->count();
    
        Exam::create([
            'department_name' => $validatedData['department_name'],
            'exam_position' => $validatedData['exam_position'],
            'exam_date' => $validatedData['exam_date'],
            'exam_start_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_start_time'],
            'exam_end_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_end_time'],
            'organization' => $randomOrganization,
            'exam_takers_quantity' => $applicantCount,
            'status' => 'pending',
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
            $rooms = $exam->selectedRooms->pluck('room_id')->toArray();
            
            Seat::whereIn('room_id', $rooms)->delete();
            
            $exam->delete();
            
            return response()->json(['success' => true, 'message' => 'Exam and associated seats deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Exam not found.'], 404);
        }
    }
    
    public function exam_building_list($examId, Request $request)
    {
        $exams = Exam::findOrFail($examId);
        $sort = $request->get('sort', 'alphabet_th'); // Default sort by building_th
        $buildings = Building::query()
            ->select('buildings.*')
            ->selectSub(
                ExamRoomInformation::query()
                    ->selectRaw('SUM(valid_seat) - COALESCE(SUM(selected_rooms.exam_valid_seat), 0) as total_valid_seats')
                    ->leftJoin('selected_rooms', function($join) use ($exams) {
                        $join->on('exam_room_information.id', '=', 'selected_rooms.room_id')
                            ->where('selected_rooms.exam_date', $exams->exam_date)
                            ->where(function($query) use ($exams) {
                                $query->where('selected_rooms.exam_start_time', '<', $exams->exam_end_time)
                                    ->where('selected_rooms.exam_end_time', '>', $exams->exam_start_time);
                            });
                    })
                    ->whereColumn('exam_room_information.building_code', 'buildings.id'),
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

    // public function exam_room_list($examId,$buildingId, Request $request)
    // {
    //     $exams = Exam::findOrFail($examId);
    //     $buildings = Building::findOrFail($buildingId);
    //     $rooms = $buildings->examRoomInformation();

    //     $sort = $request->get('sort', 'room_name_asc');
    //     switch ($sort) {
    //         case 'room_name_asc':
    //             $rooms = $rooms->orderBy('room');
    //             break;
    //         case 'room_name_desc':
    //             $rooms = $rooms->orderByDesc('room');
    //             break;
    //         default:
    //             $rooms = $rooms->orderBy('room');
    //     }

    //     $rooms = $rooms->paginate(12);
    //     $breadcrumbs = [
    //         ['url' => '/', 'title' => 'หน้าหลัก'],
    //         ['url' => '/exams', 'title' => 'รายการสอบ'],
    //         ['url' => '/exams/'.$examId.'/buildings', 'title' => ''.$exams->department_name],
    //         ['url' => '/exams/'.$examId.'/buildings/'.$buildingId, 'title' => ''.$buildings->building_th],
    //     ];
    //     session()->flash('sidebar', '3');

    //     return view('pages.exam-manage.exam-roomlist', compact('breadcrumbs', 'exams','buildings','rooms'));
    // } 
    
    public function exam_room_list($examId, $buildingId, Request $request)
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
    
        $selectedRooms = SelectedRoom::where('exam_id', $examId)->get()->keyBy('room_id');
    
        $rooms->getCollection()->transform(function ($room) use ($selectedRooms, $exams) {
            $selectedRoom = SelectedRoom::where('room_id', $room->id)
                                        ->where('exam_date', $exams->exam_date)
                                        ->where(function($query) use ($exams) {
                                            $query
                                                ->where('exam_start_time', '<', $exams->exam_end_time)
                                                ->where('exam_end_time', '>', $exams->exam_start_time);
                                        })
                                        ->first();
            $originalExamValidSeat = $selectedRoom ? $selectedRoom->exam_valid_seat : 0;
            $room->exam_valid_seat = $originalExamValidSeat;
            Log::info('Room ID: '.$room->id.' Exam Valid Seat: '.$room->exam_valid_seat);
            return $room;
        });
        
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => $exams->department_name],
            ['url' => '/exams/'.$examId.'/buildings/'.$buildingId, 'title' => $buildings->building_th],
        ];
        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-roomlist', compact('breadcrumbs', 'exams', 'buildings', 'rooms'));
    }

    protected function assignApplicantsToSeats($departmentName, $examPosition, $selectedRooms, $exam)
    {
        $applicants = Applicant::where('department', $departmentName)
                               ->where('position', $examPosition)
                               ->whereDoesntHave('seats', function($query) use ($exam) {
                                   $query->where('exam_date', $exam->exam_date)
                                         ->where('exam_start_time', $exam->exam_start_time)
                                         ->where('exam_end_time', $exam->exam_end_time);
                               })
                               ->get();
    
        $applicantIndex = 0;
        $conflictedApplicants = [];
    
        foreach ($selectedRooms as $roomData) {
            $room = ExamRoomInformation::findOrFail($roomData['id']);
            $selectedRoom = SelectedRoom::where('room_id', $room->id)->where('exam_id', $exam->id)->first();
    
            if (!$selectedRoom) {
                continue;
            }
    
            for ($i = 1; $i <= $room->rows; $i++) {
                for ($j = 1; $j <= $room->columns; $j++) {
                    if ($applicantIndex >= $applicants->count()) {
                        return $conflictedApplicants;
                    }
    
                    $seatExists = Seat::where('row', $i)
                                      ->where('column', $j)
                                      ->where('room_id', $room->id)
                                      ->where('exam_date', $exam->exam_date)
                                      ->where('exam_start_time', $exam->exam_start_time)
                                      ->where('exam_end_time', $exam->exam_end_time)
                                      ->exists();
    
                    if (!$seatExists) {
                        $applicant = $applicants[$applicantIndex];
    
                        $conflictExists = Seat::whereHas('applicant', function($query) use ($applicant) {
                                            $query->where('id_card', $applicant->id_card);
                                        })
                                        ->where('exam_date', $exam->exam_date)
                                        ->where('exam_start_time', $exam->exam_start_time)
                                        ->where('exam_end_time', $exam->exam_end_time)
                                        ->exists();
    
                        if ($conflictExists) {
                            $conflictedApplicants[] = $applicant->name;
                        } else {
                            Seat::create([
                                'room_id' => $room->id,
                                'applicant_id' => $applicant->id,
                                'row' => $i,
                                'column' => $j,
                                'exam_date' => $exam->exam_date,
                                'exam_start_time' => $exam->exam_start_time,
                                'exam_end_time' => $exam->exam_end_time,
                            ]);
                        }
                        $applicantIndex++;
                    }
                }
            }
        }
        return $conflictedApplicants;
    }
    
    
    

    // public function updateExamStatus(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'exam_id' => 'required|integer|exists:exams,id',
    //         'selected_rooms' => 'required|string',
    //     ]);
    
    //     $exam = Exam::findOrFail($validatedData['exam_id']);

    //     if (is_null($exam->exam_date) || is_null($exam->exam_start_time) || is_null($exam->exam_end_time)) {
    //         return redirect()->back()->with('status', 'Exam date or time is missing');
    //     }
    
    //     $selectedRooms = json_decode($validatedData['selected_rooms'], true);
    
    //     SelectedRoom::where('exam_id', $exam->id)->delete();
    
    //     foreach ($selectedRooms as $roomData) {
    //         SelectedRoom::create([
    //             'exam_id' => $exam->id,
    //             'room_id' => $roomData['id'],
    //             'exam_date' => $exam->exam_date,
    //             'exam_start_time' => $exam->exam_start_time,
    //             'exam_end_time' => $exam->exam_end_time,
    //         ]);
    //     }
    
    //     $conflictedApplicants = $this->assignApplicantsToSeats($exam->department_name, $exam->exam_position, $selectedRooms, $exam);
    
    //     if (count($conflictedApplicants) > 0) {
    //         return redirect()->back()->with('status', 'conflict')->with('conflictedApplicants', $conflictedApplicants);
    //     }
    
    //     $exam->status = 'ready';
    //     $exam->save();
    
    //     return redirect()->route('exam-list')->with('status', 'Exam updated to ready and rooms selected!');
    // }
    
    public function showSelectedRooms($examId)
    {
        $exams = Exam::findOrFail($examId);
        $selectedRooms = $exams->selectedRooms;
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => ''.$exams->department_name],
        ];
        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-selectedroom', compact('exams', 'selectedRooms','breadcrumbs'));
    }

    public function showExamRoomDetail($examId, $roomId)
    {
        $exams = Exam::findOrFail($examId);
        $room = ExamRoomInformation::findOrFail($roomId);
    
        $seats = Seat::where('room_id', $roomId)
                     ->where('exam_date', $exams->exam_date)
                     ->where('exam_start_time', $exams->exam_start_time)
                     ->where('exam_end_time', $exams->exam_end_time)
                     ->get();
    
        $applicants = Applicant::whereIn('id', $seats->pluck('applicant_id'))->get();
    
        $selectedRoom = SelectedRoom::where('room_id', $roomId)->where('exam_id', $examId)->first();
        $staffs = Staff::where('selected_room_id', $selectedRoom->id)->get();
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/selectedrooms', 'title' => ''.$exams->department_name],
            ['url' => '/exams/'.$examId.'/selectedrooms/'.$roomId, 'title' => ''.$room->room],
        ];

        session()->flash('sidebar', '3');
    
        return view('pages.exam-manage.exam-roomdetail', compact('exams', 'room', 'breadcrumbs', 'applicants', 'staffs', 'seats'));
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
    
        SelectedRoom::where('exam_id', $exam->id)->delete();
    
        foreach ($selectedRooms as $roomData) {
            $examValidSeat = min($roomData['validSeat'], $exam->exam_takers_quantity);
    
            SelectedRoom::create([
                'exam_id' => $exam->id,
                'room_id' => $roomData['id'],
                'exam_date' => $exam->exam_date,
                'exam_start_time' => $exam->exam_start_time,
                'exam_end_time' => $exam->exam_end_time,
                'exam_valid_seat' => $examValidSeat,
            ]);
        }
    
        $conflictedApplicants = $this->assignApplicantsToSeats($exam->department_name, $exam->exam_position, $selectedRooms, $exam);
    
        if (count($conflictedApplicants) > 0) {
            return redirect()->back()->with('status', 'conflict')->with('conflictedApplicants', $conflictedApplicants);
        }
    
        $exam->status = 'ready';
        $exam->save();
    
        return redirect()->route('exam-list')->with('status', 'Exam updated to ready and rooms selected!');
    }
    
    
    
    
    

    public function getApplicantsWithoutSeats($roomId)
    {
        // Log::info('Fetching applicants without seats for room:', ['room_id' => $roomId]);
        $room = ExamRoomInformation::findOrFail($roomId);
        $applicantsWithoutSeats = Applicant::whereDoesntHave('seats', function($query) use ($roomId) {
            $query->where('room_id', $roomId);
        })->get();
        
        // Log::info('Applicants without seats:', $applicantsWithoutSeats->toArray());
        
        return response()->json($applicantsWithoutSeats);
    }

    public function saveApplicantToSeat(Request $request)
    {
        $validatedData = $request->validate([
            'seat_id' => 'required|string',
            'applicant_id' => 'required|exists:applicants,id',
        ]);
    
        $seatId = $validatedData['seat_id'];
        $applicantId = $validatedData['applicant_id'];
    
        $seatParts = explode('-', $seatId);
        $row = $seatParts[0];
        $column = ord($seatParts[1]) - 64;
    
        $seat = Seat::where('row', $row)->where('column', $column)->first();
        if (!$seat) {
            return response()->json(['success' => false, 'message' => 'Seat not found.'], 404);
        }
    
        $roomId = $seat->room_id;
    
        $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
        if (!$selectedRoom) {
            return response()->json(['success' => false, 'message' => 'Selected room not found.'], 404);
        }
    
        $exam = Exam::findOrFail($selectedRoom->exam_id);
    
        Seat::where('row', $row)
            ->where('column', $column)
            ->where('room_id', $roomId)
            ->delete();
    
        Seat::create([
            'room_id' => $roomId,
            'applicant_id' => $applicantId,
            'row' => $row,
            'column' => $column,
            'exam_date' => $exam->exam_date,
            'exam_start_time' => $exam->exam_start_time,
            'exam_end_time' => $exam->exam_end_time,
        ]);
    
        return response()->json(['success' => true]);
    }
    

    public function removeApplicantFromSeat(Request $request)
    {
        // Log::info('Starting to remove applicant from seat', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'seat_id' => 'required|integer',
                'room_id' => 'required|integer|exists:selected_rooms,room_id' // Change table to selected_rooms
            ]);
    
            // Log::info('Request data validated successfully', ['validated_data' => $validatedData]);

            $seat = Seat::where('id', $validatedData['seat_id'])
                        ->where('room_id', $validatedData['room_id'])
                        ->first();
    
            if ($seat) {
                // Log::info('Seat found', ['seat' => $seat]);
    
                $seat->applicant_id = null;
                $seat->save();
    
                // Log::info('Applicant removed from seat successfully');
                return response()->json(['success' => true]);
            } else {
                Log::warning('Seat not found', ['seat_id' => $validatedData['seat_id'], 'room_id' => $validatedData['room_id']]);
                return response()->json(['success' => false, 'message' => 'Seat not found.'], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error removing applicant from seat', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to remove applicant from seat.'], 500);
        }
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

    public function updateValidSeatCount(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer|exists:exam_room_information,id',
            'valid_seat_count' => 'required|integer',
        ]);
    
        $selectedRooms = SelectedRoom::where('room_id', $validatedData['room_id'])->get();
    
        if ($selectedRooms->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Selected rooms not found.'], 404);
        }
    
        foreach ($selectedRooms as $selectedRoom) {
            $selectedRoom->exam_valid_seat = $validatedData['valid_seat_count'];
            $selectedRoom->save();
        }
    
        return response()->json(['success' => true]);
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
