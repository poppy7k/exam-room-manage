<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Log;
use App\Models\Exam;

class ApplicantController extends Controller
{
    
    public function getApplicantsWithoutSeats($examId, $roomId)
    {
        // Fetch the exam details
        $exam = Exam::findOrFail($examId);

        // Get all conflicting exam IDs that have the same date, start time, end time, and room
        $conflictingExamIds = Exam::where('exam_date', $exam->exam_date)
                                  ->where('exam_start_time', '<=', $exam->exam_end_time)
                                  ->where('exam_end_time', '>=', $exam->exam_start_time)
                                  ->whereHas('selectedRooms', function ($query) use ($roomId) {
                                      $query->where('room_id', $roomId);
                                  })
                                  ->pluck('id');

        // Find all applicants without seats for the conflicting exams
        $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($conflictingExamIds) {
            $query->whereIn('exams.id', $conflictingExamIds);
        })->whereDoesntHave('seats', function ($query) use ($conflictingExamIds, $roomId) {
            $query->whereHas('selectedRoom.exam', function ($query) use ($conflictingExamIds, $roomId) {
                $query->whereIn('exam_id', $conflictingExamIds)
                      ->where('room_id', $roomId);
            });
        })->get();

        // Log::info('Applicants without seats:', $applicantsWithoutSeats->toArray());

        return response()->json($applicantsWithoutSeats);
    }
    
}
