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
        
            Log::debug('Saving Staffs', ['room_id' => $roomId, 'examiners' => $examiners, 'exam_id' => $examId]);
        
            $selectedRoom = SelectedRoom::where('room_id', $roomId)->where('exam_id', $examId)->first();
        
            if ($selectedRoom) {
                Log::debug('Found selected room', ['selected_room_id' => $selectedRoom->id]);
        
                // Get current staff for the room and exam
                $currentStaffIds = $selectedRoom->staffs->pluck('id')->toArray();
                $newStaffIds = array_column($examiners, 'id');
        
                // Detach staff members that are not in the new list
                $staffToDetach = array_diff($currentStaffIds, $newStaffIds);
                if (!empty($staffToDetach)) {
                    $selectedRoom->staffs()->detach($staffToDetach);
                    Log::debug('Detached staff members', ['staff_ids' => $staffToDetach, 'selected_room_id' => $selectedRoom->id]);
                }
        
                // Attach new staff members
                foreach ($newStaffIds as $staffId) {
                    if (!in_array($staffId, $currentStaffIds)) {
                        $selectedRoom->staffs()->attach($staffId, ['exam_id' => $examId]);
                        Log::debug('Attached new staff member', ['staff_id' => $staffId, 'selected_room_id' => $selectedRoom->id]);
                    }
                }
        
                // Duplicate staff assignments for all other exams with the same date, time, and room
                $this->duplicateStaffAssignments($selectedRoom, $newStaffIds, $staffToDetach);
            }
        
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving staff: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Failed to save staff.'], 500);
        }
    }
    

    public function duplicateStaffAssignments($selectedRoom, $newStaffIds, $staffToDetach)// case selected staff after create all involve case same room same time
    {
        $newExam = $selectedRoom->exam;
        Log::info('Starting to duplicate staff assignments', ['new_exam_id' => $newExam->id]);
        
        // Find existing exams with the same date and time but different IDs
        $existingExams = Exam::where('exam_date', $newExam->exam_date)
                             ->where('exam_start_time', $newExam->exam_start_time)
                             ->where('exam_end_time', $newExam->exam_end_time)
                             ->where('id', '!=', $newExam->id)
                             ->get();
        
        Log::info('Found existing exams with the same date and time', ['existing_exams' => $existingExams]);
        
        foreach ($existingExams as $existingExam) {
            Log::info('Processing existing exam', ['existing_exam_id' => $existingExam->id]);
        
            $existingSelectedRoom = SelectedRoom::where('room_id', $selectedRoom->room_id)
                                                 ->where('exam_id', $existingExam->id)
                                                 ->first();
        
            if ($existingSelectedRoom) {
                Log::info('Found corresponding selected room for existing exam', ['existing_selected_room_id' => $existingSelectedRoom->id]);
        
                // Detach staff members that are not in the new list
                if (!empty($staffToDetach)) {
                    $existingSelectedRoom->staffs()->detach($staffToDetach);
                    Log::debug('Detached staff members from existing selected room', ['staff_ids' => $staffToDetach, 'selected_room_id' => $existingSelectedRoom->id]);
                }
        
                // Attach new staff members
                foreach ($newStaffIds as $staffId) {
                    $exists = DB::table('room_staff')
                        ->where('selected_room_id', $existingSelectedRoom->id)
                        ->where('staff_id', $staffId)
                        ->where('exam_id', $existingExam->id)
                        ->exists();
        
                    if (!$exists) {
                        $existingSelectedRoom->staffs()->attach($staffId, ['exam_id' => $existingExam->id]);
                        Log::debug('Attached new staff member to existing selected room', ['staff_id' => $staffId, 'selected_room_id' => $existingSelectedRoom->id]);
                    }
                }
            }
        }
        
        Log::info('Completed duplicating staff assignments');
    }
    

    public function duplicateStaffAssignments2($newExam)// case selected staff in (exam)s before create another (exam)s
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
