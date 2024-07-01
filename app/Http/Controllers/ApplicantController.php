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
        //Log::info('Fetching applicants without seats for room and exam:', ['room_id' => $roomId, 'exam_id' => $examId]);
    
        $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($examId) {
            $query->where('exams.id', $examId)->where('applicant_exam.status', 'not_assigned');
        })->whereDoesntHave('seats', function ($query) use ($roomId) {
            $query->where('seats.selected_room_id', $roomId);
        })->get();
    
        //Log::info('Applicants without seats:', $applicantsWithoutSeats->toArray());
    
        return response()->json($applicantsWithoutSeats);
    }
    
}
