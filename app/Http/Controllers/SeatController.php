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
                                    })->whereHas('selected_room', function ($query) use ($exam) {
                                        $query->where('exam_id', $exam->exam_id)
                                        ->whereHas('exam', function ($query) use ($exam) {
                                            $query->where('exam_date', $exam->exam_date)
                                                  ->where('exam_start_time', $exam->exam_start_time)
                                                  ->where('exam_end_time', $exam->exam_end_time);
                                        });
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
        $validatedData = $request->validate([
            'seat_id' => 'required|string',
            'applicant_id' => 'required|exists:applicants,id',
        ]);
    
        $seatId = $validatedData['seat_id'];
        $applicantId = $validatedData['applicant_id'];
    
        $seatParts = explode('-', $seatId);
        $row = $seatParts[0];
        $column = ord($seatParts[1]) - 64;
    
        $seat = Seat::where('row', $row)->where('column', $column)->first();
        if (!$seat) {
            return response()->json(['success' => false, 'message' => 'Seat not found.'], 404);
        }
    
        $roomId = $seat->room_id;
    
        $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
        if (!$selectedRoom) {
            return response()->json(['success' => false, 'message' => 'Selected room not found.'], 404);
        }
    
        $exam = Exam::findOrFail($selectedRoom->exam_id);
    
        Seat::where('row', $row)
            ->where('column', $column)
            ->where('room_id', $roomId)
            ->delete();
    
        Seat::create([
            'room_id' => $roomId,
            'applicant_id' => $applicantId,
            'row' => $row,
            'column' => $column,
            'exam_date' => $exam->exam_date,
            'exam_start_time' => $exam->exam_start_time,
            'exam_end_time' => $exam->exam_end_time,
        ]);
    
        return response()->json(['success' => true]);
    }
    

    public function removeApplicantFromSeat(Request $request)
    {
        // Log::info('Starting to remove applicant from seat', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'seat_id' => 'required|integer',
                'room_id' => 'required|integer|exists:selected_rooms,room_id' // Change table to selected_rooms
            ]);
    
            // Log::info('Request data validated successfully', ['validated_data' => $validatedData]);

            $seat = Seat::where('id', $validatedData['seat_id'])
                        ->where('room_id', $validatedData['room_id'])
                        ->first();
    
            if ($seat) {
                // Log::info('Seat found', ['seat' => $seat]);
    
                $seat->applicant_id = null;
                $seat->save();
    
                // Log::info('Applicant removed from seat successfully');
                return response()->json(['success' => true]);
            } else {
                Log::warning('Seat not found', ['seat_id' => $validatedData['seat_id'], 'room_id' => $validatedData['room_id']]);
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
