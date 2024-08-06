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
use Carbon\Carbon;
use App\Http\Controllers\NotificationController;

class ExamController extends Controller
{
    protected $staffController;
    protected $seatController;
    protected $notifications;

    public function __construct(StaffController $staffController, SeatController $seatController, NotificationController $notifications)
    {
        $this->staffController = $staffController;
        $this->seatController = $seatController;
        $this->notifications = $notifications;
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

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'department_name' => 'required|string',
    //         'exam_position' => 'required|string',
    //         'exam_date' => 'required|date',
    //         'exam_start_time' => 'required|date_format:H:i',
    //         'exam_end_time' => 'required|date_format:H:i',
    //         'subject' => 'required|string',
    //     ]);
    //     $organizations = ["สำนักกองบริหารกลาง"];
    //     $randomOrganization = $organizations[array_rand($organizations)];
    //     $applicantCount = Applicant::where('department', $validatedData['department_name'])
    //                             ->where('position', $validatedData['exam_position'])
    //                             ->count();
    
    //     $exam = Exam::create([
    //         'department_name' => $validatedData['department_name'],
    //         'exam_position' => $validatedData['exam_position'],
    //         'exam_date' => $validatedData['exam_date'],
    //         'exam_start_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_start_time'],
    //         'exam_end_time' => $validatedData['exam_date'] . ' ' . $validatedData['exam_end_time'],
    //         'organization' => $randomOrganization,
    //         'exam_takers_quantity' => $applicantCount,
    //         'status' => 'pending',
    //         'subject' => $validatedData['subject'],
    //     ]);

    //     session()->flash('status', 'success');
    //     session()->flash('message', 'สร้างการสอบสำเร็จ!');
    
    //     return redirect()->route('exam-list');
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_name' => 'required|string',
            'exam_position' => 'required|string',
            'exam_date' => 'required|date',
            'exam_start_time' => 'required|date_format:H:i',
            'exam_end_time' => 'required|date_format:H:i',
            'subject' => 'required|string',
            'selected_applicants' => 'nullable|string',
        ]);
    
        $organizations = ["สำนักกองบริหารกลาง"];
        $randomOrganization = $organizations[array_rand($organizations)];
    
        $applicantCount = 0;
        $selectedApplicants = [];
    
        if (!empty($validatedData['selected_applicants'])) {
            $selectedApplicants = explode(',', $validatedData['selected_applicants']);
            $applicantCount = count($selectedApplicants);
        } else {
            $applicantCount = Applicant::where('department', $validatedData['department_name'])
                                       ->where('position', $validatedData['exam_position'])
                                       ->count();
        }
    
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
    
        if (!empty($selectedApplicants)) {
            foreach ($selectedApplicants as $applicantId) {
                $exam->applicants()->attach($applicantId, ['status' => 'not_assigned']);
            }
        }
    
        $this->notifications->success('สร้างการสอบเสร็จสิ้น!');
    
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
        
        //Log::info('Departments:', $departments->toArray());
        //Log::info('Positions:', $positions->toArray());

        $exam_takers_quantity = 0;

        session()->flash('sidebar', '3');

        return view('pages.exam-manage.exam-create', compact('breadcrumbs', 'departments', 'positions','applicants','exam_takers_quantity'));
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
        $sort = $request->get('sort', 'alphabet_th');

        $buildings = Building::query()
            ->select('buildings.*')
            ->selectSub(
                ExamRoomInformation::query()
                    ->selectRaw('SUM(valid_seat) as total_valid_seats')
                    ->whereColumn('exam_room_information.building_id', 'buildings.id'),
                'total_valid_seats'
            )
            ->selectSub(
                ExamRoomInformation::query()
                    ->selectRaw('COALESCE(SUM(selected_rooms.applicant_seat_quantity), 0)')
                    ->leftJoin('selected_rooms', function($join) use ($exams) {
                        $join->on('exam_room_information.id', '=', 'selected_rooms.room_id')
                            ->leftJoin('exams', 'selected_rooms.exam_id', '=', 'exams.id')
                            ->where('exams.exam_date', $exams->exam_date)
                            ->where('exams.exam_start_time', '<', $exams->exam_end_time)
                            ->where('exams.exam_end_time', '>', $exams->exam_start_time);
                    })
                    ->whereColumn('exam_room_information.building_id', 'buildings.id'),
                'total_applicant_seat_quantity'
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
        $buildingsValidSeat = $buildings->items();
    
        $breadcrumbs = [
            ['url' => '/', 'title' => 'หน้าหลัก'],
            ['url' => '/exams', 'title' => 'รายการสอบ'],
            ['url' => '/exams/'.$examId.'/buildings', 'title' => $exams->department_name],
        ];
        session()->flash('sidebar', '3');
    
        // Logging to debug the calculation of valid seats
        //Log::debug('Buildings with total valid seats:', $buildings->toArray());
    
        return view('pages.exam-manage.exam-buildinglist', compact('breadcrumbs', 'exams', 'buildings'));
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
                                        ->sum('selected_rooms.applicant_seat_quantity');
            $room->valid_seat = $selectedRoom ? $room->valid_seat - $selectedRoom : $room->valid_seat;
            //Log::info('Room ID: '.$room->id.' Exam Valid Seat: '.$room->valid_seat);
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
    
        // $seats = Seat::where('selected_room_id', $selectedRoomId)
        //              ->get();
        $seats = Seat::whereHas('selectedRoom.exam', function ($query) use ($exam, $room) {
            $query->where('exam_date', $exam->exam_date)
                  ->where('exam_start_time', '<=', $exam->exam_end_time)
                  ->where('exam_end_time', '>=', $exam->exam_start_time)
                  ->where('room_id', $room->id);
        })->get();
        // Log::info('Seats:', $seats->toArray());
    
        // $applicants = Applicant::whereIn('id', $seats->pluck('applicant_id'))->get();
        $applicants = Applicant::whereIn('id', $seats->pluck('applicant_id'))->get()->map(function ($applicant) use ($examId) {
            $applicant->exam_id = $examId;
            return $applicant;
        });
        $applicantExams = DB::table('applicant_exam')
            ->whereIn('applicant_id', $applicants->pluck('id'))
            ->get();
    
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
    
        return view('pages.exam-manage.exam-roomdetail', compact('applicantExams','selectedRooms','building','exam', 'room', 'breadcrumbs', 'applicants', 'staffs', 'seats', 'assignedStaffs','departments','positions'));
    }
    
    public function createExams(Request $request)
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
        //Log::debug('Selected Rooms', ['selectedRooms' => $selectedRooms]);
    
        // Check for conflicts before creating selected rooms
        $conflictedApplicants = $this->seatController->checkApplicantConflicts(Applicant::where('department', $exam->department_name)->where('position', $exam->exam_position)->get(), $exam);
    
        //Log::debug('Conflicted Applicants', ['count' => count($conflictedApplicants)]);
    
        if (count($conflictedApplicants) > 0) {
            return redirect()->back()->with('status', 'conflict')->with('conflictedApplicants', $conflictedApplicants);
        }
    
        // No conflicts, proceed to create selected rooms
        SelectedRoom::where('exam_id', $exam->id)->delete();
        //Log::debug('Deleted existing selected rooms');
    
        foreach ($selectedRooms as $roomData) {
            $room = ExamRoomInformation::findOrFail($roomData['id']);
            $applicantSeatQuantity = $roomData['usedSeat'];
    
            // Call the new method to calculate and update valid seats
            $this->seatController->SelectedroomValidSeatUpdate($room, $exam, $applicantSeatQuantity);
        }
    
        // Call the assignApplicantsToSeats function to create seats
        $conflictedApplicants = $this->seatController->assignApplicantsToSeats($exam->department_name, $exam->exam_position, $selectedRooms, $exam);
    
        if (count($conflictedApplicants) > 0) {
            return redirect()->back()->with('status', 'conflict')->with('conflictedApplicants', $conflictedApplicants);
        }

        $this->staffController->duplicateStaffAssignments2($exam);

        $exam->status = 'ready';
        $exam->save();
    
        //Log::debug('Exam updated to ready');
        return redirect()->route('exam-list')->with('status', 'Exam updated to ready and rooms selected!');
    }

    public function updateExamStatuses()
    {
        try {
            $currentDateTime = Carbon::now();
            //Log::info('Current date and time', ['currentDateTime' => $currentDateTime->toDateTimeString()]);
            // Get all exams
            $exams = Exam::all();
    
            foreach ($exams as $exam) {
                $startTime = Carbon::parse($exam->exam_date)->setTimeFromTimeString($exam->exam_start_time);
                $endTime = Carbon::parse($exam->exam_date)->setTimeFromTimeString($exam->exam_end_time);
    
                // Log the current exam details
                // Log::info('Processing exam', [
                //     'exam_id' => $exam->id,
                //     'startTime' => $startTime->toDateTimeString(),
                //     'endTime' => $endTime->toDateTimeString(),
                //     'currentStatus' => $exam->status
                // ]);
                // Log the current exam details
                //Log::info('Processing exam', ['exam_id' => $exam->id]);
    
                // Get applicants registered for the exam
                $registeredApplicants = $exam->applicants;
    
                // Log registered applicants
                // Log::info('Registered applicants for exam', [
                //     'exam_id' => $exam->id,
                //     'applicants' => $registeredApplicants->pluck('id')->toArray()
                // ]);
    
                // Filter applicants without seats
                // $applicantsWithoutSeats = $registeredApplicants->filter(function ($applicant) use ($exam) {
                //     return !Seat::where('applicant_id', $applicant->id)
                //                 ->whereHas('selectedRoom', function ($query) use ($exam) {
                //                     $query->where('exam_id', $exam->id);
                //                 })
                //                 ->exists();
                // });
                $applicantsWithoutSeats = DB::table('applicant_exam')
                ->where('exam_id', $exam->id)
                ->where('status', 'not_assigned')
                ->pluck('applicant_id');
    
                // Log applicants without seats
                // Log::info('Applicants without seats for exam', [
                //     'exam_id' => $exam->id,
                //     'applicants' => $applicantsWithoutSeats->pluck('id')->toArray()
                // ]);
                Log::info('Applicants without seats for exam', [
                    'exam_id' => $exam->id,
                    'applicants' => $applicantsWithoutSeats->pluck('id')->toArray(),
                    'applicants_isnotempty' => $applicantsWithoutSeats->isNotEmpty(),
                ]);

                if ($applicantsWithoutSeats->isNotEmpty() && $exam->status !== 'unready') {
                    // Update status to 'unready'
                    if ($exam->status === 'ready') {
                        $exam->status = 'unready';
                        $exam->save();
                        //Log::info("Updated exam status to 'unready'", ['exam_id' => $exam->id]);
                    }
                } elseif ($applicantsWithoutSeats->isEmpty() && $exam->status === 'unready') {
                    // Update status to 'ready' if previously unready and no applicants without seats
                    $exam->status = 'ready';
                    $exam->save();
                    //Log::info("Updated exam status to 'ready'", ['exam_id' => $exam->id]);
                } elseif ($currentDateTime->between($startTime, $endTime)) {
                    // Update status to 'inprogress'
                    if ($exam->status === 'ready') {
                        $exam->status = 'inprogress';
                        $exam->save();
                        //Log::info("Updated exam status to 'inprogress'", ['exam_id' => $exam->id]);
                    }
                } elseif ($currentDateTime->gt($endTime)) {
                    // Update status to 'finished'
                    // if ($exam->status === 'inprogress' || $exam->status === 'ready') { prevent to change to case finished immediately (testing case unfinished)
                    if ($exam->status === 'inprogress') {
                        $exam->status = 'finished';
                        $exam->save();
                        //Log::info("Updated exam status to 'finished'", ['exam_id' => $exam->id]);
                    }elseif ($exam->status === 'unready'){
                        $exam->status = 'unfinished';
                        $exam->save();
                        //Log::info("Updated exam status to 'unfinished'", ['exam_id' => $exam->id]);
                    }
                }
            }
            // Log::info('Final exam status after processing', [
            //     'exam_id' => $exam->id,
            //     'finalStatus' => $exam->status
            // ]);
    
            return response()->json(['success' => true, 'message' => 'Exam statuses updated successfully', 'exams' => $exams]);
        } catch (\Exception $e) {
            Log::error('Error updating exam statuses', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to update exam statuses.'], 500);
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
    

    public function getExamsWithAffectedChangeLayouts(Request $request)
    {
        $invalidSeats = $request->input('invalidSeats', []);
        $roomId = $request->input('roomId');
        $newRows = (int)$request->input('rows');
        $newColumns = (int)$request->input('columns');
    
        // Fetch the room details to get the old values
        $room = ExamRoomInformation::findOrFail($roomId);
        $oldRows = $room->rows;
        $oldColumns = $room->columns;
    
        //Log::debug('Old rows and columns', ['oldRows' => $oldRows, 'oldColumns' => $oldColumns]);
        //Log::debug('New rows and columns', ['newRows' => $newRows, 'newColumns' => $newColumns]);
    
        // Parse invalid seats
        $invalidSeatsParsed = array_map(function($seat) {
            list($row, $columnLetter) = explode('-', $seat);
            $columnNumber = 0;
            $length = strlen($columnLetter);
            for ($i = 0; $i < $length; $i++) {
                $columnNumber = $columnNumber * 26 + (ord($columnLetter[$i]) - ord('A') + 1);
            }
            return ['row' => (int) $row, 'column' => $columnNumber];
        }, $invalidSeats);
    
        if ($newRows == $oldRows && $newColumns == $oldColumns && empty($invalidSeatsParsed)) {
            //Log::debug('No changes in rows or columns, skipping update');
            return response()->json([]);
        }
        //Log::debug('invalidSeatsParsed', ['invalidSeatsParsed' => $invalidSeatsParsed]);
    
        // Combine invalid seats with changes in rows/columns
        $affectedSeats = $invalidSeatsParsed;
    
        // Check if rows or columns have changed
        if ($newRows != $oldRows || $newColumns != $oldColumns) {
            //Log::debug('Rows or columns have changed, adding all seats to affected list');
            
            for ($row = 1; $row <= $oldRows; $row++) {
                for ($col = 1; $col <= $oldColumns; $col++) {
                    // Only add if it's not already in invalid seats
                    $seat = ['row' => $row, 'column' => $col];
                    if (!in_array($seat, $invalidSeatsParsed)) {
                        $affectedSeats[] = $seat;
                    }
                }
            }
        }
    
        //Log::debug('Affected seats', ['affectedSeats' => $affectedSeats]);
    
        // Query exams for affected seats
        $exams = DB::table('applicant_exam')
            ->join('seats', 'applicant_exam.applicant_id', '=', 'seats.applicant_id')
            ->join('exams', 'applicant_exam.exam_id', '=', 'exams.id')
            ->join('selected_rooms', 'applicant_exam.exam_id', '=', 'selected_rooms.exam_id')
            ->where('selected_rooms.room_id', $roomId)
            ->where('applicant_exam.status', 'assigned')
            ->where('exams.status', '!=', 'inprogress')
            ->where('exams.status', '!=', 'finished')
            ->where('exams.status', '!=', 'unfinished')
            ->where(function ($query) use ($affectedSeats) {
                foreach ($affectedSeats as $seat) {
                    $query->orWhere(function ($subQuery) use ($seat) {
                        $subQuery->where('seats.row', $seat['row'])
                                 ->where('seats.column', $seat['column']);
                    });
                }
            })
            ->select('exams.id', 'exams.department_name as name')
            ->distinct()
            ->get();
    
        //Log::debug('Fetched Exams', ['exams' => $exams]);
    
        return response()->json($exams);
    }
    
    public function updateExamSeatLayouts(Request $request)
    {
        $examIds = $request->input('exams');
        $roomId = $request->input('roomId');
        $newRows = (int)$request->input('rows');
        $newColumns = (int)$request->input('columns');
        $invalidSeats = $request->input('invalidSeats', []);
        
        // Fetch the room details to get the old values
        $room = ExamRoomInformation::findOrFail($roomId);
        $oldRows = $room->rows;
        $oldColumns = $room->columns;
        
        //Log::debug('Old rows and columns', ['oldRows' => $oldRows, 'oldColumns' => $oldColumns]);
        //Log::debug('New rows and columns', ['newRows' => $newRows, 'newColumns' => $newColumns]);
        
        // Parse invalid seats
        $invalidSeatsParsed = array_map(function($seat) {
            list($row, $columnLetter) = explode('-', $seat);
            $columnNumber = 0;
            $length = strlen($columnLetter);
            for ($i = 0; $i < $length; $i++) {
                $columnNumber = $columnNumber * 26 + (ord($columnLetter[$i]) - ord('A') + 1);
            }
            return ['row' => (int) $row, 'column' => $columnNumber];
        }, $invalidSeats);
        
        //Log::debug('Invalid seats parsed', ['invalidSeatsParsed' => $invalidSeatsParsed]);

        // Set recent_change to 0 for all selected_rooms
        DB::table('selected_rooms')->update(['recent_change' => 0]);
        // Set exam_recent_change to 0 for all exams
        DB::table('exams')->update(['exam_recent_change' => 0]);
        //update the one that changed to 1
        DB::table('selected_rooms')->where('room_id', $roomId)->update(['recent_change' => 1]);

        // Update exam_recent_change to 1 for exams with any selected_room having recent_change = 1
        DB::table('exams')
            ->whereIn('id', function ($query) {
                $query->select('exam_id')
                      ->from('selected_rooms')
                      ->where('recent_change', 1);
            })
            ->update(['exam_recent_change' => 1]);
        
        // Get applicants for affected exams sorted by id_number
        $affectedApplicants = DB::table('applicant_exam')
            ->join('seats', 'applicant_exam.applicant_id', '=', 'seats.applicant_id')
            ->join('selected_rooms', 'applicant_exam.exam_id', '=', 'selected_rooms.exam_id')
            ->join('applicants', 'applicant_exam.applicant_id', '=', 'applicants.id')
            ->whereIn('applicant_exam.exam_id', $examIds)
            ->where('selected_rooms.room_id', $roomId)
            ->select('applicant_exam.applicant_id', 'applicants.id_number', 'selected_rooms.id as selected_room_id')
            ->distinct()
            ->orderBy('applicants.id_number', 'asc')
            ->get()
            ->groupBy('selected_room_id');
        
        //Log::debug('Affected Applicants', ['affectedApplicants' => $affectedApplicants]);
        
        // Calculate affected seats based on the new layout
        $affectedSeats = [];
        for ($row = 1; $row <= $newRows; $row++) {
            for ($col = 1; $col <= $newColumns; $col++) {
                $affectedSeats[] = ['row' => $row, 'column' => $col];
            }
        }
        
        // Exclude invalid seats
        $affectedSeats = array_filter($affectedSeats, function($seat) use ($invalidSeatsParsed) {
            return !in_array($seat, $invalidSeatsParsed);
        });
        
        //Log::debug('Affected seats calculated', ['affectedSeats' => $affectedSeats]);
        
        // Update seats to null for affected applicants
        foreach ($affectedApplicants as $selectedRoomId => $applicants) {
            $applicantIds = $applicants->pluck('applicant_id');
            
            $updateCount = DB::table('seats')
                ->whereIn('applicant_id', $applicantIds)
                ->where('selected_room_id', $selectedRoomId)
                ->update(['row' => null, 'column' => null]);
            
            //Log::debug('Seats updated to null for affected applicants', ['selectedRoomId' => $selectedRoomId, 'updateCount' => $updateCount]);
        }
        
        // Delete extra seats before creating new seat records
        $this->seatController->deleteExtraSeats($roomId, $newRows, $newColumns);

        $selectedRoom = SelectedRoom::find($selectedRoomId);
        $selectedRoom->update(['applicant_seat_quantity' => 0]);
    
        // Reassign seats to all applicants
        foreach ($affectedApplicants as $selectedRoomId => $applicants) {
            $seatIndex = 0;
            foreach ($applicants as $applicant) {
                $this->seatController->assignApplicantToSeatWithNewLayouts($applicant->applicant_id, $selectedRoomId, $newRows, $newColumns, $invalidSeatsParsed, $seatIndex);
            }
        }
        
        //Log::debug('Exam statuses updated and seats reassigned');

        return response()->json(['success' => true]);
    }

    public function getExamsByDate($date)
    {
        // ดึงข้อมูลการสอบตามวันที่
        $exams = Exam::whereDate('exam_date', $date)->get();

        // ดึง exam_id จากการสอบ
        $examIds = $exams->pluck('id');

        // ดึง SelectedRoom ที่มี exam_id ตรงกับที่ดึงมา
        $selectedRooms = SelectedRoom::whereIn('exam_id', $examIds)->get();

        // ดึง room_id จาก SelectedRoom
        $roomIds = $selectedRooms->pluck('room_id')->unique()->toArray();

        // ดึงข้อมูล ExamRoomInformation ที่มี room_id ตรงกับที่ดึงมา
        $rooms = ExamRoomInformation::whereIn('id', $roomIds)->get()->keyBy('id');

        // ดึงข้อมูล Building สำหรับห้องที่เกี่ยวข้อง
        $buildingIds = $rooms->pluck('building_id')->unique()->toArray();
        $buildings = Building::whereIn('id', $buildingIds)->get()->keyBy('id');

        // เพิ่มข้อมูลห้องและอาคารไปที่แต่ละ exam
        $exams->each(function($exam) use ($selectedRooms, $rooms, $buildings) {
            // ข้อมูลห้องที่เกี่ยวข้องกับการสอบ
            $exam->rooms = $selectedRooms->where('exam_id', $exam->id)
                ->pluck('room_id')
                ->map(function($roomId) use ($rooms) {
                    $room = $rooms->get($roomId);
                    return $room ? $room->room : '';
                })
                ->filter()
                ->whenEmpty(function($query) {
                    return $query->push('ยังไม่ได้เลือก');
                })
                ->implode(', '); // ใช้ ', ' เป็นตัวคั่นระหว่างห้อง
        
            // ข้อมูลอาคารที่เกี่ยวข้องกับห้องที่มีการสอบ
            $exam->buildings = $selectedRooms->where('exam_id', $exam->id)
                ->pluck('room_id')
                ->map(function($roomId) use ($rooms, $buildings) {
                    $room = $rooms->get($roomId);
                    if ($room) {
                        $building = $buildings->get($room->building_id);
                        return $building ? $building->building_th : 'Unknown Building';
                    }
                    return 'Unknown Building';
                })
                ->unique()
                ->whenEmpty(function($query) {
                    return $query->push('ยังไม่ได้เลือก');
                })
                ->implode(', '); // ใช้ ', ' เป็นตัวคั่นระหว่างชื่ออาคาร
        });

        // ส่งข้อมูลกลับเป็น JSON
        return response()->json($exams);
    }
}
