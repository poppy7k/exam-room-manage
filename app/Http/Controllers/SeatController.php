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
        // Log::debug('Starting assignApplicantsToSeats', [
        //     'departmentName' => $departmentName,
        //     'examPosition' => $examPosition,
        //     'selectedRooms' => $selectedRooms,
        //     'exam' => $exam
        // ]);
    
        $applicants = Applicant::where('department', $departmentName)
                               ->where('position', $examPosition)
                               ->get();
    
        //Log::debug('Applicants retrieved', ['count' => $applicants->count()]);
    
        $applicantIndex = 0;
    
        // Check for conflicts
        $conflictedApplicants = $this->checkApplicantConflicts($applicants, $exam);
        //Log::debug('Conflicted Applicants', ['count' => count($conflictedApplicants)]);
    
        if (count($conflictedApplicants) > 0) {
            return $conflictedApplicants;
        }
    
        // Remove conflicted applicants from the list
        $applicants = $applicants->filter(function ($applicant) use ($conflictedApplicants) {
            return !in_array($applicant->name, $conflictedApplicants);
        });
    
        //Log::debug('Filtered Applicants', ['count' => $applicants->count()]);
    
        $totalSeats = 0;
        foreach ($selectedRooms as $roomData) {
            $room = ExamRoomInformation::findOrFail($roomData['id']);
            $totalSeats += $room->rows * $room->columns;
        }
    
        //Log::debug('Total Seats Available', ['totalSeats' => $totalSeats]);
    
        if ($applicants->count() > $totalSeats) {
            // Log::error('Not enough seats for all applicants', [
            //     'required_seats' => $applicants->count(),
            //     'available_seats' => $totalSeats
            // ]);
            return array_unique($conflictedApplicants);
        }
    
        $selectedRoomIds = array_column($selectedRooms, 'id');
        $isMultiRoomSameTimeSingleExam = (count($selectedRoomIds) > 1);
        //Log::debug("multiroom", ['isMultiRoomSameTimeSingleExam' => $isMultiRoomSameTimeSingleExam]);

        foreach ($selectedRooms as $roomData) {
            $room = ExamRoomInformation::findOrFail($roomData['id']);
            $selectedRoom = SelectedRoom::firstOrCreate(['room_id' => $room->id, 'exam_id' => $exam->id]);
    
            //Log::debug('Selected Room Created', ['selectedRoom' => $selectedRoom]);
            $invalidSeats = json_decode($room->invalid_seats, true) ?? [];
    
            for ($i = 1; $i <= $room->rows; $i++) {
                for ($j = 1; $j <= $room->columns; $j++) {
                    $seatId = "{$i}-" . chr(64 + $j); // Converts column number to letter

                    if (in_array($seatId, $invalidSeats)) {
                        // Skip deactivated seat
                        continue;
                    } 
                    if ($applicantIndex >= $applicants->count()) {
                        //Log::debug('All applicants assigned', ['applicantIndex' => $applicantIndex]);
                        return array_unique($conflictedApplicants);
                    }
    
                    $seatExists = Seat::where('row', $i)
                                      ->where('column', $j)
                                      ->where('selected_room_id', $selectedRoom->id)
                                      ->exists();
    
                    //Log::debug('Checking Seat', ['row' => $i, 'column' => $j, 'seatExists' => $seatExists]);
    
                    if ($isMultiRoomSameTimeSingleExam) { //case multi room ,same time,single exam 
                        $seatOccupiedSameTime = Seat::where('row', $i)
                                                    ->where('column', $j)
                                                    ->whereHas('selectedRoom.exam', function ($query) use ($exam) {
                                                        $query->where('exam_date', $exam->exam_date)
                                                              ->where('exam_start_time', $exam->exam_start_time)
                                                              ->where('exam_end_time', $exam->exam_end_time);
                                                    })
                                                    ->whereIn('selected_room_id', $selectedRoomIds)
                                                    ->exists();
                    } else { //case single room ,same time , multi exam
                        $seatOccupiedSameTime = Seat::where('row', $i)
                                                    ->where('column', $j)
                                                    ->whereIn('selected_room_id', function ($query) use ($selectedRoomIds, $exam) {
                                                        $query->select('selected_rooms.id')
                                                              ->from('selected_rooms')
                                                              ->join('exams', 'selected_rooms.exam_id', '=', 'exams.id')
                                                              ->whereIn('selected_rooms.room_id', $selectedRoomIds)
                                                              ->where('exams.exam_date', $exam->exam_date)
                                                              ->where('exams.exam_start_time', $exam->exam_start_time)
                                                              ->where('exams.exam_end_time', $exam->exam_end_time);
                                                    })
                                                    ->exists();
                    }
    
                    //Log::debug('Seat Occupied Same Time', ['seatOccupiedSameTime' => $seatOccupiedSameTime]);
    
                    if (!$seatExists && !$seatOccupiedSameTime) {
                        $applicant = $applicants->values()->get($applicantIndex);
    
                        // Log::debug('Assigning Applicant', [
                        //     'applicantIndex' => $applicantIndex,
                        //     'applicant' => $applicant
                        // ]);
    
                        Seat::create([
                            'selected_room_id' => $selectedRoom->id,
                            'applicant_id' => $applicant->id,
                            'row' => $i,
                            'column' => $j,
                        ]);
    
                        if (!$exam->applicants()->where('applicant_id', $applicant->id)->exists()) {
                            $exam->applicants()->attach($applicant->id, ['status' => 'assigned']);
                        } else {
                            $exam->applicants()->updateExistingPivot($applicant->id, ['status' => 'assigned']);
                        }
    
                        //Log::debug('Applicant Assigned to Seat', ['applicant' => $applicant]);
    
                        $applicantIndex++;
                    } else {
                        //Log::debug('Seat is already occupied', ['row' => $i, 'column' => $j, 'room_id' => $room->id]);
                    }
                }
            }
        }
    
        //Log::debug('Finished assigning applicants to seats');
        return array_unique($conflictedApplicants);
    }
    
    public function checkApplicantConflicts($applicants, $exam)
    {
        $conflictedApplicants = [];
        $conflictedApplicantNames = [];
        
        // Log::debug('Checking applicant conflicts', [
        //     'exam_date' => $exam->exam_date,
        //     'exam_start_time' => $exam->exam_start_time,
        //     'exam_end_time' => $exam->exam_end_time
        // ]);
        
        foreach ($applicants as $applicant) {
            //Log::debug('Checking applicant', ['applicant_id' => $applicant->id, 'id_card' => $applicant->id_card]);
    
            $conflictExists = Exam::whereHas('applicants', function ($query) use ($applicant) {
                    $query->where('id_card', $applicant->id_card);
                })
                ->where('exam_date', $exam->exam_date)
                ->where('exam_start_time', $exam->exam_start_time)
                ->where('exam_end_time', $exam->exam_end_time)
                ->exists();
    
            //Log::debug('Conflict exists', ['conflictExists' => $conflictExists]);
    
            if ($conflictExists) {
                if (!in_array($applicant->name, $conflictedApplicantNames)) {
                    $conflictedApplicants[] = $applicant->name;
                    $conflictedApplicantNames[] = $applicant->name;
                }
                //Log::debug('Applicant conflict found', ['applicant_id' => $applicant->id, 'id_card' => $applicant->id_card, 'exam_id' => $exam->id]);
            }
        }
    
        //Log::debug('Conflicted applicants', ['conflictedApplicants' => $conflictedApplicants]);
        return array_unique($conflictedApplicants);
    }

    public function SelectedroomValidSeatUpdate($room, $exam, $applicantSeatQuantity)
    {
        //Log::debug('Processing room', ['room_id' => $room->id, 'applicantSeatQuantity' => $applicantSeatQuantity]);
    
        // Calculate the remaining valid seats for the first setup
        $initialValidSeats = $room->valid_seat - $applicantSeatQuantity;
        //Log::debug('Initial valid seats for the first setup', ['initialValidSeats' => $initialValidSeats]);
    
        // Create the selected room record
        $selectedRoom = SelectedRoom::create([
            'exam_id' => $exam->id,
            'room_id' => $room->id,
            'applicant_seat_quantity' => $applicantSeatQuantity,
            'selectedroom_valid_seat' => $initialValidSeats,
        ]);
    
        //Log::debug('Selected room created', ['selectedRoom' => $selectedRoom]);
    
        // Ensure other records with the same room_id and overlapping exam times are updated
        $overlappingExams = SelectedRoom::where('room_id', $room->id)
                            ->whereHas('exam', function($query) use ($exam) {
                                $query->where('exam_date', $exam->exam_date)
                                      ->where('exam_start_time', $exam->exam_start_time)
                                      ->where('exam_end_time', $exam->exam_end_time);
                            })
                            ->get();
    
        //Log::debug('Overlapping exams', ['count' => $overlappingExams->count()]);
    
        foreach ($overlappingExams as $overlappingExam) {
            // Sum of all applicant seat quantities in overlapping exams
            $totalUsedSeatsInOverlappingExams = SelectedRoom::where('room_id', $room->id)
                                                            ->whereHas('exam', function($query) use ($exam) {
                                                                $query->where('exam_date', $exam->exam_date)
                                                                      ->where('exam_start_time', $exam->exam_start_time)
                                                                      ->where('exam_end_time', $exam->exam_end_time);
                                                            })
                                                            ->sum('applicant_seat_quantity');
            //Log::debug('Total used seats in overlapping exams', ['totalUsedSeatsInOverlappingExams' => $totalUsedSeatsInOverlappingExams]);
    
            $remainingSeats = max(0, $room->valid_seat - $totalUsedSeatsInOverlappingExams);
            $overlappingExam->update(['selectedroom_valid_seat' => $remainingSeats]);
    
            //Log::debug('Updated overlapping exam', ['overlappingExam' => $overlappingExam, 'remainingSeats' => $remainingSeats]);
        }
    }
    
    public function saveApplicantToSeat(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'seat_id' => 'required|string',
                'applicant_id' => 'required|exists:applicants,id',
                'room_id' => 'required|integer|exists:exam_room_information,id',
                'exam_id' => 'required|exists:exams,id',
            ]);
    
            $seatId = $validatedData['seat_id'];
            $applicantId = $validatedData['applicant_id'];
            $roomId = $validatedData['room_id'];
            $examId = $validatedData['exam_id'];
    
            $exam = Exam::findOrFail($examId);

            // Check the status of the exam
            if (in_array($exam->status, ['inprogress', 'finished', 'unfinished'])) {
                return response()->json(['success' => false, 'message' => 'ไม่สามารถแก้ไขผู้เข้าสอบในวันเวลาดังกล่าว'], 400);
            }
    
            $seatParts = explode('-', $seatId);
            $row = $seatParts[0];
            $column = ord($seatParts[1]) - 64;
    
            // Fetch the selected room for the specific exam
            $selectedRoom = SelectedRoom::where('room_id', $roomId)->where('exam_id', $examId)->first();
    
            if (!$selectedRoom) {
                Log::warning('Selected room not found', ['room_id' => $roomId, 'exam_id' => $examId]);
                return response()->json(['success' => false, 'message' => 'Selected room not found.'], 404);
            }
    
            // Fetch the exam related to the selected room
            $exam = Exam::findOrFail($selectedRoom->exam_id);
    
            // Ensure the seat record exists for the specific exam and selected room
            $seat = Seat::firstOrCreate(
                [
                    'row' => $row,
                    'column' => $column,
                    'selected_room_id' => $selectedRoom->id
                ],
                [
                    'applicant_id' => null // Only create the seat if it has no applicant assigned
                ]
            );
    
            // If the seat is already occupied by another applicant in this specific exam and room
            if ($seat->applicant_id) {
                return response()->json(['success' => false, 'message' => 'Seat is already occupied.'], 400);
            }
    
            // Check for time conflicts
            // $conflictExists = Exam::where('id', '!=', $exam->id)
            //     ->where('exam_date', $exam->exam_date)
            //     ->where('exam_start_time', '<=', $exam->exam_end_time)
            //     ->where('exam_end_time', '>=', $exam->exam_start_time)
            //     ->whereHas('applicants', function($query) use ($applicantId) {
            //         $query->where('applicant_id', $applicantId);
            //     })->exists();
    
            // if ($conflictExists) {
            //     return response()->json(['success' => false, 'message' => 'Applicant has a time conflict with another exam.'], 400);
            // }
    
            // Assign the applicant to the seat
            $seat->applicant_id = $applicantId;
            $seat->save();
    
            // Attach the applicant to the exam with status 'assigned'
            $exam->applicants()->syncWithoutDetaching([$applicantId => ['status' => 'assigned']]);

            // Decrement the selectedroom_valid_seat by 1
            $selectedRoom->decrement('selectedroom_valid_seat');
            $selectedRoom->save();
    
            //Log::info('Applicant assigned to seat successfully');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error saving applicant to seat', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to assign applicant to seat.'], 500);
        }
    }
    
    public function removeApplicantFromSeat(Request $request)
    {
        //Log::info('Starting to remove applicant from seat', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'seat_id' => 'required|integer',
                'room_id' => 'required|integer|exists:selected_rooms,room_id' // Ensure room_id exists in selected_rooms table
            ]);
    
            //Log::info('Request data validated successfully', ['validated_data' => $validatedData]);
    
            // Fetch the seat using the provided seat_id
            $seat = Seat::find($validatedData['seat_id']);
            
            if ($seat) {
                //Log::info('Seat found', ['seat' => $seat]);
                
                // Fetch the selected room
                $selectedRoom = SelectedRoom::where('room_id', $validatedData['room_id'])
                                            ->where('id', $seat->selected_room_id)
                                            ->first();
                                            
                if ($selectedRoom) {
                    //Log::info('Selected room found', ['selected_room' => $selectedRoom]);
                    // Fetch the exam
                    $exam = Exam::find($selectedRoom->exam_id);

                    // Check the status of the exam
                    if (in_array($exam->status, ['inprogress', 'finished', 'unfinished'])) {
                        return response()->json(['success' => false, 'message' => 'ไม่สามารถแก้ไขผู้เข้าสอบในวันเวลาดังกล่าว'], 400);
                    }
                    
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

                        // Increment the selectedroom_valid_seat by 1
                        $selectedRoom->increment('selectedroom_valid_seat');
                        $selectedRoom->save();
    
                        //Log::info('Applicant removed from seat successfully');
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

    public function removeApplicantsFromRoom(Request $request)
    {
        Log::info('Starting to remove applicants from all seats in the rooms with matching exam and time', ['request_data' => $request->all()]);
    
        try {
            $validatedData = $request->validate([
                'exam_date' => 'required|date',
                'exam_start_time' => 'required|date',
                'exam_end_time' => 'required|date'
            ]);
    
            Log::info('Request data validated successfully', ['validated_data' => $validatedData]);
    
            // Fetch the selected rooms with matching exam_id and exam times
            $selectedRooms = SelectedRoom::whereHas('exam', function ($query) use ($validatedData) {
                    $query->where('exam_date', $validatedData['exam_date'])
                          ->where('exam_start_time', $validatedData['exam_start_time'])
                          ->where('exam_end_time', $validatedData['exam_end_time']);
                })
                ->get();
    
            if ($selectedRooms->isNotEmpty()) {
                Log::info('Selected rooms found', ['selected_rooms' => $selectedRooms]);
    
                // Loop through each selected room to fetch and update seats
                foreach ($selectedRooms as $selectedRoom) {
                    // Fetch all seats in the selected room
                    $seats = Seat::where('selected_room_id', $selectedRoom->id)->get();
    
                    // Loop through all seats to remove applicants
                    foreach ($seats as $seat) {
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
    
                            Log::info('Applicant removed from seat successfully', ['seat' => $seat]);
                        } else {
                            Log::warning('No applicant assigned to this seat', ['seat' => $seat]);
                        }
                    }
                }
    
                Log::info('All applicants removed from rooms with matching exam and time successfully');
                return response()->json(['success' => true]);
            } else {
                Log::warning('No selected rooms found with matching exam and time', ['exam_id' => $validatedData['exam_id'], 'exam_date' => $validatedData['exam_date'], 'exam_start_time' => $validatedData['exam_start_time'], 'exam_end_time' => $validatedData['exam_end_time']]);
                return response()->json(['success' => false, 'message' => 'No selected rooms found with matching exam and time.'], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error removing applicants from seats in the rooms', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to remove applicants from seats in the rooms.'], 500);
        }
    }    

    // public function updateValidSeatCount(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'room_id' => 'required|integer|exists:exam_room_information,id',
    //         'exam_id' => 'required|integer|exists:exams,id',
    //         'valid_seat_count' => 'required|integer',
    //     ]);
    
    //     // Get the exam details
    //     $exam = Exam::findOrFail($validatedData['exam_id']);
    
    //     // Find all selected rooms that have the same room_id and overlap in time with the provided exam
    //     $selectedRooms = SelectedRoom::where('room_id', $validatedData['room_id'])
    //         ->whereHas('exam', function($query) use ($exam) {
    //             $query->where('exam_date', $exam->exam_date)
    //                 ->where('exam_start_time', '<', $exam->exam_end_time)
    //                 ->where('exam_end_time', '>', $exam->exam_start_time);
    //         })
    //         ->get();
    
    //     if ($selectedRooms->isEmpty()) {
    //         return response()->json(['success' => false, 'message' => 'Selected rooms not found.'], 404);
    //     }
    
    //     // Update applicant_seat_quantity for all matching selected rooms
    //     foreach ($selectedRooms as $selectedRoom) {
    //         $selectedRoom->applicant_seat_quantity = $validatedData['valid_seat_count'];
    //         $selectedRoom->save();
    //     }
    
    //     return response()->json(['success' => true]);
    // }
    
}
