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

    // public function getApplicantsWithoutSeats($examId, $roomId)
    // {
    //     // Fetch the exam details
    //     $exam = Exam::findOrFail($examId);
    //     // Log::info('Exam details fetched', ['exam' => $exam]);
    
    //     // Get all conflicting exam IDs that have the same date, start time, end time, and room
    //     $conflictingExamIds = Exam::where('exam_date', $exam->exam_date)
    //         ->where('exam_start_time', '<=', $exam->exam_end_time)
    //         ->where('exam_end_time', '>=', $exam->exam_start_time)
    //         ->whereHas('selectedRooms', function ($query) use ($roomId) {
    //             $query->where('room_id', $roomId);
    //         })
    //         ->pluck('id');
    //     // Log::info('Conflicting exam IDs', ['conflictingExamIds' => $conflictingExamIds]);
    
    //     if ($conflictingExamIds->isEmpty()) {
    //         // Log::warning('No conflicting exams found.');
    //         return response()->json([]);
    //     }
    
    //     // Fetch applicants with status 'not_assigned' from the applicant_exam table for the conflicting exams
    //     $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($conflictingExamIds) {
    //         $query->whereIn('exam_id', $conflictingExamIds)
    //             ->where('applicant_exam.status', 'not_assigned');
    //     })->get();
    //     // Log::info('Applicants without seats', ['applicantsWithoutSeats' => $applicantsWithoutSeats]);
    
    //     if ($applicantsWithoutSeats->isEmpty()) {
    //         // Log::warning('No applicants found without seats.');
    //         return response()->json([]);
    //     }
    
    //     return response()->json($applicantsWithoutSeats);
    // }

    public function getApplicantsWithoutSeats($examId, $roomId)
    {
        try {
            // Fetch the exam details
            $exam = Exam::findOrFail($examId);
            //Log::info('Exam details fetched', ['exam' => $exam]);
    
            /*
            // Get all conflicting exam IDs that have the same date, start time, end time, and room
            $conflictingExamIds = Exam::where('exam_date', $exam->exam_date)
                ->where('exam_start_time', '<=', $exam->exam_end_time)
                ->where('exam_end_time', '>=', $exam->exam_start_time)
                ->whereHas('selectedRooms', function ($query) use ($roomId) {
                    $query->where('room_id', $roomId);
                })
                ->pluck('id');
            Log::info('Conflicting exam IDs', ['conflictingExamIds' => $conflictingExamIds]);
    
            if ($conflictingExamIds->isEmpty()) {
                Log::warning('No conflicting exams found.');
                return response()->json([]);
            }
            */
    
            // Directly fetch applicants with status 'not_assigned' for the current exam
            $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($examId) {
                $query->where('exam_id', $examId)
                    ->where('applicant_exam.status', 'not_assigned');
            })
            ->whereDoesntHave('seats', function ($query) use ($examId) {
                $query->whereIn('selected_room_id', function ($query) use ($examId) {
                    $query->select('id')
                        ->from('selected_rooms')
                        ->where('exam_id', $examId);
                });
            })
            ->get();
            //Log::info('Applicants without seats', ['applicantsWithoutSeats' => $applicantsWithoutSeats]);
    
            if ($applicantsWithoutSeats->isEmpty()) {
                Log::warning('No applicants found without seats.');
                return response()->json([]);
            }
    
            return response()->json($applicantsWithoutSeats);
        } catch (\Exception $e) {
            Log::error('Error fetching applicants without seats', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while fetching applicants without seats.'], 500);
        }
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

    public function fetchApplicants(Request $request)
    {
        $department = $request->query('department');
        $position = $request->query('position');
    
        Log::debug('Department:', ['department' => $department]);
        Log::debug('Position:', ['position' => $position]);
    
        // Fetch applicants by department and position
        // Include those who either do not have a record in applicant_exam or have a status of 'not_assigned'
        $applicants = Applicant::where('department', $department)
                               ->where('position', $position)
                               ->where(function ($query) {
                                   $query->whereDoesntHave('exams')
                                         ->orWhereHas('exams', function ($subQuery) {
                                             $subQuery->where('applicant_exam.status', 'not_assigned');
                                         });
                               })
                               ->get();
    
        Log::debug('Applicants:', ['applicants' => $applicants->toArray()]);
    
        return response()->json($applicants);
    }
    

}