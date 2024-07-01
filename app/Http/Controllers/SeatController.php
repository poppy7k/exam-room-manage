<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ExamRoomInformation;
use App\Models\SelectedRoom;
use App\Models\Seat;
use App\Models\Exam;
use Illuminate\Support\Facades\Log;

class SeatController extends Controller
{
    public function assignApplicantsToSeats($departmentName, $examPosition, $selectedRooms, $exam)
    {
        $applicants = Applicant::where('department', $departmentName)
                               ->where('position', $examPosition)
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
                                      ->where('selected_room_id', $selectedRoom->id)
                                      ->exists();
    
                    if (!$seatExists) {
                        $applicant = $applicants[$applicantIndex];
    
                        $conflictExists = Seat::whereHas('applicant', function($query) use ($applicant) {
                                            $query->where('id_card', $applicant->id_card);
                                        })
                                        ->whereHas('selectedRoom.exam', function ($query) use ($exam) {
                                            $query->where('exam_id', $exam->id)
                                                  ->where('exam_date', $exam->exam_date)
                                                  ->where('exam_start_time', $exam->exam_start_time)
                                                  ->where('exam_end_time', $exam->exam_end_time);
                                        })
                                        ->exists();
    
                        if ($conflictExists) {
                            $conflictedApplicants[] = $applicant->name;
                        } else {
                            Seat::create([
                                'selected_room_id' => $selectedRoom->id,
                                'applicant_id' => $applicant->id,
                                'row' => $i,
                                'column' => $j,
                            ]);
    
                            // Update the status in the pivot table
                            if (!$exam->applicants()->where('applicant_id', $applicant->id)->exists()) {
                                $exam->applicants()->attach($applicant->id, ['status' => 'assigned']);
                            } else {
                                $exam->applicants()->updateExistingPivot($applicant->id, ['status' => 'assigned']);
                            }
                        }
                        $applicantIndex++;
                    }
                }
            }
        }
        return $conflictedApplicants;
    }
    
    
    public function saveApplicantToSeat(Request $request)
    {
        Log::info('Starting to save applicant to seat', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'seat_id' => 'required|string',
                'applicant_id' => 'required|exists:applicants,id',
                'room_id' => 'required|integer|exists:exam_room_information,id',
            ]);
    
            Log::info('Request data validated successfully', ['validated_data' => $validatedData]);
    
            $seatId = $validatedData['seat_id'];
            $applicantId = $validatedData['applicant_id'];
            $roomId = $validatedData['room_id'];
    
            $seatParts = explode('-', $seatId);
            $row = $seatParts[0];
            $column = ord($seatParts[1]) - 64;
    
            $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
            if (!$selectedRoom) {
                Log::warning('Selected room not found', ['room_id' => $roomId]);
                return response()->json(['success' => false, 'message' => 'Selected room not found.'], 404);
            }
    
            $exam = Exam::findOrFail($selectedRoom->exam_id);
    
            $seat = Seat::where('row', $row)
                        ->where('column', $column)
                        ->where('selected_room_id', $selectedRoom->id)
                        ->first();
    
            if (!$seat) {
                Log::warning('Seat not found', ['row' => $row, 'column' => $column, 'selected_room_id' => $selectedRoom->id]);
                return response()->json(['success' => false, 'message' => 'Seat not found.'], 404);
            }
    
            // Delete any existing seat assignment for this row and column in the selected room
            Seat::where('row', $row)
                ->where('column', $column)
                ->where('selected_room_id', $selectedRoom->id)
                ->delete();
    
            // Create a new seat assignment
            Seat::create([
                'selected_room_id' => $selectedRoom->id,
                'applicant_id' => $applicantId,
                'row' => $row,
                'column' => $column,
                'exam_date' => $exam->exam_date,
                'exam_start_time' => $exam->exam_start_time,
                'exam_end_time' => $exam->exam_end_time,
            ]);
    
            // Attach the applicant to the exam with status 'assigned'
            $exam->applicants()->syncWithoutDetaching([$applicantId => ['status' => 'assigned']]);
    
            Log::info('Applicant assigned to seat successfully');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving applicant to seat', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to assign applicant to seat.'], 500);
        }
    }
    

    public function removeApplicantFromSeat(Request $request)
    {
        Log::info('Starting to remove applicant from seat', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'seat_id' => 'required|integer',
                'room_id' => 'required|integer|exists:selected_rooms,room_id' // Ensure room_id exists in selected_rooms table
            ]);
    
            Log::info('Request data validated successfully', ['validated_data' => $validatedData]);
    
            // Fetch the seat using the provided seat_id
            $seat = Seat::find($validatedData['seat_id']);
            
            if ($seat) {
                Log::info('Seat found', ['seat' => $seat]);
                
                // Fetch the selected room
                $selectedRoom = SelectedRoom::where('room_id', $validatedData['room_id'])
                                            ->where('id', $seat->selected_room_id)
                                            ->first();
                                            
                if ($selectedRoom) {
                    Log::info('Selected room found', ['selected_room' => $selectedRoom]);
                    
                    // Ensure seat has an applicant assigned
                    if ($seat->applicant_id !== null) {
                        // Update the pivot table to set status to not_assigned
                        $exam = Exam::find($selectedRoom->exam_id);
                        if ($exam) {
                            $exam->applicants()->updateExistingPivot($seat->applicant_id, ['status' => 'not_assigned']);
                        }
    
                        // Remove the applicant from the seat
                        $seat->applicant_id = null;
                        $seat->save();
    
                        Log::info('Applicant removed from seat successfully');
                        return response()->json(['success' => true]);
                    } else {
                        Log::warning('No applicant assigned to this seat', ['seat' => $seat]);
                        return response()->json(['success' => false, 'message' => 'No applicant assigned to this seat.'], 404);
                    }
                } else {
                    Log::warning('Selected room not found', ['seat' => $seat, 'room_id' => $validatedData['room_id']]);
                    return response()->json(['success' => false, 'message' => 'Selected room not found.'], 404);
                }
            } else {
                Log::warning('Seat not found', ['seat_id' => $validatedData['seat_id']]);
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

    public function updateValidSeatCount(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer|exists:exam_room_information,id',
            'exam_id' => 'required|integer|exists:exams,id',
            'valid_seat_count' => 'required|integer',
        ]);
    
        $selectedRooms = SelectedRoom::where('room_id', $validatedData['room_id'])->where('exam_id', $validatedData['exam_id'])->get();
    
        if ($selectedRooms->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Selected rooms not found.'], 404);
        }
    
        foreach ($selectedRooms as $selectedRoom) {
            $selectedRoom->applicant_seat_quantity = $validatedData['valid_seat_count'];
            $selectedRoom->save();
        }
    
        return response()->json(['success' => true]);
    } 
}
