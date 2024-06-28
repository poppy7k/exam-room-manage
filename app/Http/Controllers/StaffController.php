<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\SelectedRoom;
use Illuminate\Support\Facades\Log;
use App\Models\Exam;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        return response()->json($staffs);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        
}
