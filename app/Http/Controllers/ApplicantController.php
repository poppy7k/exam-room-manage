<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Log;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use App\Models\Seat;

class ApplicantController extends Controller
{
    
    public function getApplicantsWithoutSeats($examId, $roomId)
    {
        // Fetch the exam details
        $exam = Exam::findOrFail($examId);
        //Log::info('Exam details fetched', ['exam' => $exam]);
    
        // Get all conflicting exam IDs that have the same date, start time, end time, and room
        $conflictingExamIds = Exam::where('exam_date', $exam->exam_date)
                                  ->where('exam_start_time', '<=', $exam->exam_end_time)
                                  ->where('exam_end_time', '>=', $exam->exam_start_time)
                                  ->whereHas('selectedRooms', function ($query) use ($roomId) {
                                      $query->where('room_id', $roomId);
                                  })
                                  ->pluck('id');
        //Log::info('Conflicting exam IDs', ['conflictingExamIds' => $conflictingExamIds]);
    
        if ($conflictingExamIds->isEmpty()) {
            Log::warning('No conflicting exams found.');
            return response()->json([]);
        }
    
        // Fetch all applicants for the conflicting exams
        $applicantsForConflictingExams = Applicant::whereHas('exams', function ($query) use ($conflictingExamIds) {
            $query->whereIn('exams.id', $conflictingExamIds);
        })->get();
        //Log::info('Applicants for conflicting exams', ['applicantsForConflictingExams' => $applicantsForConflictingExams]);
    
        if ($applicantsForConflictingExams->isEmpty()) {
            Log::warning('No applicants found for conflicting exams.');
            return response()->json([]);
        }
    
        // Fetch seats with null row and column for the conflicting exams and room
        $seatsWithNullRowColumn = Seat::whereNull('row')
                                      ->whereNull('column')
                                      ->whereIn('selected_room_id', function ($query) use ($conflictingExamIds, $roomId) {
                                          $query->select('id')
                                                ->from('selected_rooms')
                                                ->whereIn('exam_id', $conflictingExamIds)
                                                ->where('room_id', $roomId);
                                      })
                                      ->get();
        //Log::info('Seats with null row and column', ['seatsWithNullRowColumn' => $seatsWithNullRowColumn]);
    
        if ($seatsWithNullRowColumn->isEmpty()) {
            Log::warning('No seats with null row and column found.');
            return response()->json([]);
        }
    
        // Find all applicants without seats (null row and column) for the conflicting exams
        $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($conflictingExamIds) {
            $query->whereIn('exams.id', $conflictingExamIds);
        })->whereHas('seats', function ($query) use ($seatsWithNullRowColumn) {
            $query->whereIn('id', $seatsWithNullRowColumn->pluck('id'));
        })->get();
    
        //Log::info('Applicants without seats', ['applicantsWithoutSeats' => $applicantsWithoutSeats]);
    
        return response()->json($applicantsWithoutSeats);
    }

    public function getNewApplicants($examId)
    {
        $exam = Exam::findOrFail($examId);
        $applicants = Applicant::where('department', $exam->department_name)
                               ->where('position', $exam->exam_position)
                               ->get();
    
        $newApplicants = [];
        foreach ($applicants as $applicant) {
            $exists = DB::table('applicant_exam')
                ->where('applicant_id', $applicant->id)
                ->where('exam_id', $examId)
                ->exists();
    
            if (!$exists) {
                $newApplicants[] = $applicant;
            }
        }
    
        return response()->json(['success' => true, 'newApplicants' => $newApplicants]);
    }

    public function updateNewApplicants(Request $request, $examId)
    {
        $applicants = $request->input('applicants', []);
        
        foreach ($applicants as $applicantId) {
            DB::table('applicant_exam')->updateOrInsert(
                ['applicant_id' => $applicantId, 'exam_id' => $examId],
                ['status' => 'not_assigned']
            );
        }
        
        return response()->json(['success' => true]);
    }

    public function getApplicantsToDelete($examId)
    {
        try {
            $exam = Exam::findOrFail($examId);
            $applicants = $exam->applicants;
    
            return response()->json(['success' => true, 'applicants' => $applicants]);
        } catch (\Exception $e) {
            Log::error('Error fetching applicants to delete', ['exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to fetch applicants to delete.'], 500);
        }
    }
    
    public function deleteApplicants(Request $request, $examId)
    {
        try {
            $applicantIds = $request->input('applicants');
    
            DB::transaction(function () use ($applicantIds, $examId) {
                DB::table('seats')->whereIn('applicant_id', $applicantIds)->delete();
                DB::table('applicant_exam')->where('exam_id', $examId)->whereIn('applicant_id', $applicantIds)->delete();
            });
    
            return response()->json(['success' => true, 'message' => 'Applicants deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting applicants', ['exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete applicants.'], 500);
        }
    }    

}
