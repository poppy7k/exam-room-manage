<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\SelectedRoom;
use Illuminate\Support\Facades\Log;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{

    public function index()
    {
        $staffs = Staff::all();
        return response()->json($staffs);
    }
    
    public function saveStaffs(Request $request)
    {
        try {
            $roomId = $request->input('room_id');
            $examiners = $request->input('examiners');
            $examId = $request->input('exam_id');
    
            $selectedRoom = SelectedRoom::where('room_id', $roomId)->where('exam_id', $examId)->first();
    
            if ($selectedRoom) {
                // Detach all current staff for the room and exam
                $selectedRoom->staffs()->detach();
    
                // Attach the new staff members
                foreach ($examiners as $examiner) {
                    $staff = Staff::find($examiner['id']);
                    if ($staff) {
                        $selectedRoom->staffs()->attach($staff->id, ['exam_id' => $examId]);
                    }
                }
    
                // Find other exams with the same date and time
                $existingExams = Exam::where('exam_date', $selectedRoom->exam_date)
                                     ->where('exam_start_time', $selectedRoom->exam_start_time)
                                     ->where('exam_end_time', $selectedRoom->exam_end_time)
                                     ->where('id', '!=', $examId)
                                     ->get();
    
                foreach ($existingExams as $existingExam) {
                    $existingSelectedRoom = SelectedRoom::where('room_id', $roomId)
                                                         ->where('exam_id', $existingExam->id)
                                                         ->first();
    
                    if ($existingSelectedRoom) {
                        // Detach all current staff for the existing room and exam
                        $existingSelectedRoom->staffs()->detach();
    
                        // Attach the new staff members
                        foreach ($examiners as $examiner) {
                            $staff = Staff::find($examiner['id']);
                            if ($staff) {
                                $existingSelectedRoom->staffs()->attach($staff->id, ['exam_id' => $existingExam->id]);
                            }
                        }
                    }
                }
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving staff: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Failed to save staff.'], 500);
        }
    }

    public function duplicateStaffAssignments($newExam)
    {
        //Log::info('Starting to duplicate staff assignments', ['new_exam_id' => $newExam->id]);
    
        // Find existing exams with the same date and time but different IDs
        $existingExams = Exam::where('exam_date', $newExam->exam_date)
                             ->where('exam_start_time', $newExam->exam_start_time)
                             ->where('exam_end_time', $newExam->exam_end_time)
                             ->where('id', '!=', $newExam->id)
                             ->get();
    
        //Log::info('Found existing exams with the same date and time', ['existing_exams' => $existingExams]);
    
        foreach ($existingExams as $existingExam) {
            //Log::info('Processing existing exam', ['existing_exam_id' => $existingExam->id]);
    
            $existingSelectedRooms = SelectedRoom::where('exam_id', $existingExam->id)->get();
            //Log::info('Found selected rooms for existing exam', ['selected_rooms' => $existingSelectedRooms]);
    
            foreach ($existingSelectedRooms as $selectedRoom) {
                //Log::info('Duplicating staff assignments for selected room', ['selected_room_id' => $selectedRoom->id]);
    
                // Find the corresponding selected room for the new exam
                $newSelectedRoom = SelectedRoom::where('exam_id', $newExam->id)
                                               ->where('room_id', $selectedRoom->room_id)
                                               ->first();
    
                if (!$newSelectedRoom) {
                    Log::error('No corresponding selected room found for new exam', ['new_exam_id' => $newExam->id, 'room_id' => $selectedRoom->room_id]);
                    continue;
                }
    
                foreach ($selectedRoom->staffs as $staff) {
                    //Log::info('Attaching staff to new exam', ['staff_id' => $staff->id]);
    
                    // Explicitly attach the staff to the new exam and log the operation
                    DB::table('room_staff')->insert([
                        'selected_room_id' => $newSelectedRoom->id,
                        'staff_id' => $staff->id,
                        'exam_id' => $newExam->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
                    //Log::info('Attached staff to new exam', ['staff_id' => $staff->id, 'new_exam_id' => $newExam->id, 'new_selected_room_id' => $newSelectedRoom->id]);
    
                    // Verify the attachment in the database
                    // $roomStaffRecord = DB::table('room_staff')
                    //     ->where('selected_room_id', $newSelectedRoom->id)
                    //     ->where('staff_id', $staff->id)
                    //     ->where('exam_id', $newExam->id)
                    //     ->first();
    
                    // if ($roomStaffRecord) {
                    //     Log::info('Room staff record exists in the database', ['room_staff_record' => $roomStaffRecord]);
                    // } else {
                    //     Log::error('Failed to attach staff to the new exam', ['staff_id' => $staff->id, 'new_exam_id' => $newExam->id, 'new_selected_room_id' => $newSelectedRoom->id]);
                    // }
                }
            }
        }
    
        //Log::info('Completed duplicating staff assignments');
    }

}
