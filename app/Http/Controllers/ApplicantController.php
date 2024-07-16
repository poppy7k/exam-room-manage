<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Log;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    
    public function getApplicantsWithoutSeats($examId, $roomId)
    {
        try {
            // Fetch the exam details
            $exam = Exam::findOrFail($examId);
            Log::info('Exam details fetched', ['exam' => $exam]);
    
            // Get all conflicting exam IDs that have the same date, start time, end time, and room
            $conflictingExamIds = Exam::where('exam_date', $exam->exam_date)
                                      ->where('exam_start_time', '<=', $exam->exam_end_time)
                                      ->where('exam_end_time', '>=', $exam->exam_start_time)
                                      ->whereHas('selectedRooms', function ($query) use ($roomId) {
                                          $query->where('room_id', $roomId);
                                      })
                                      ->pluck('id');
            Log::info('Conflicting exam IDs fetched', ['conflictingExamIds' => $conflictingExamIds]);
    
            // Find all applicants without seats for the conflicting exams
            $applicantsWithoutSeats = Applicant::whereHas('exams', function ($query) use ($conflictingExamIds) {
                    $query->whereIn('exams.id', $conflictingExamIds);
                })
                ->whereDoesntHave('seats', function ($query) use ($conflictingExamIds, $roomId) {
                    $query->whereHas('selectedRoom.exam', function ($query) use ($conflictingExamIds, $roomId) {
                        $query->whereIn('exam_id', $conflictingExamIds)
                              ->where('room_id', $roomId);
                    });
                })
                ->get();
    
            Log::info('Applicants without seats fetched', ['applicantsWithoutSeats' => $applicantsWithoutSeats]);
    
            // Find applicants with status 'not_assigned' for the specified exam
            $applicantsNotAssigned = Applicant::whereHas('exams', function ($query) use ($examId) {
                $query->where('exam_id', $examId)
                      ->where('applicant_exam.status', 'not_assigned');
            })->get();
    
            Log::info('Applicants with not_assigned status fetched', ['applicantsNotAssigned' => $applicantsNotAssigned]);
    
            // Merge the two collections
            $allApplicants = $applicantsWithoutSeats->merge($applicantsNotAssigned);
    
            return response()->json($allApplicants);
        } catch (\Exception $e) {
            Log::error('Error fetching applicants without seats', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while fetching applicants without seats.'], 500);
        }
    }
    

    public function updateApplicantExamStatus(Request $request)
    {
        try {
            $applicantId = $request->input('applicant_id');
            $examId = $request->input('exam_id');
            $status = $request->input('status');
    
            Log::info('status', ['status' => $status]);
    
            // Check current status before updating
            $currentStatus = DB::table('applicant_exam')
                ->where('applicant_id', $applicantId)
                ->where('exam_id', $examId)
                ->value('status');
    
            if ($currentStatus !== $status) {
                // Update the status in the applicant_exam table
                DB::table('applicant_exam')
                    ->where('applicant_id', $applicantId)
                    ->where('exam_id', $examId)
                    ->update(['status' => $status]);
    
                // Set applicant_id to null in seats table if status is not_assigned
                if ($status === 'not_assigned') {
                    DB::table('seats')
                        ->where('applicant_id', $applicantId)
                        ->where('selected_room_id', function($query) use ($examId) {
                            $query->select('selected_room_id')
                                ->from('selected_rooms')
                                ->where('exam_id', $examId)
                                ->limit(1);
                        })
                        ->update(['applicant_id' => null]);
                }
    
                return response()->json(['success' => true, 'message' => 'Applicant exam status updated successfully.']);
            } else {
                return response()->json(['success' => true, 'message' => 'No update needed, status unchanged.']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating applicant exam status', ['exception' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update applicant exam status.']);
        }
    }

}
