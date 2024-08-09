<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\ExamRoomInformation;
use App\Models\SelectedRoom;
use App\Models\Seat;
use App\Models\Exam;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    public function checkSeatAvailability($selectedRoomId, $applicantId, $startTime, $endTime, $row, $column)
    {
        // Log::info('Checking seat availability:', [
        //     'selected_room_id' => $selectedRoomId,
        //     'applicant_id' => $applicantId,
        //     'start_time' => $startTime,
        //     'end_time' => $endTime,
        //     'row' => $row,
        //     'column' => $column
        // ]);

        $seatAvailable = Seat::isSeatAvaliable($selectedRoomId, $applicantId, $startTime, $endTime, $row, $column);

        return $seatAvailable;
    }

    public function assignApplicantsToSeats($departmentName, $examPosition, $selectedRooms, $exam)
    {
        // Reset previous assignments
        $exam->applicants()->updateExistingPivot(
            $exam->applicants()->pluck('applicants.id'), ['status' => 'not_assigned']
        );
    
        // Retrieve applicants that are not assigned
        $applicants = $exam->applicants()->wherePivot('status', 'not_assigned')->get();
    
        // Log applicants retrieved
        Log::debug('Applicants retrieved', ['count' => $applicants->count()]);
    
        $applicantIndex = 0;
    
        // Check for conflicts
        $conflictedApplicants = $this->checkApplicantConflicts($applicants, $exam);
        
        if (count($conflictedApplicants) > 0) {
            return $conflictedApplicants;
        }
    
        // Remove conflicted applicants from the list
        $applicants = $applicants->filter(function ($applicant) use ($conflictedApplicants) {
            return !in_array($applicant->name, $conflictedApplicants);
        });
    
        // Log filtered applicants
        Log::debug('Filtered Applicants', ['count' => $applicants->count()]);
    
        $selectedRoomIds = array_column($selectedRooms, 'id');
        $isMultiRoomSameTimeSingleExam = (count($selectedRoomIds) > 1);
    
        foreach ($selectedRooms as $roomData) {
            $room = ExamRoomInformation::findOrFail($roomData['id']);
            $selectedRoom = SelectedRoom::firstOrCreate(['room_id' => $room->id, 'exam_id' => $exam->id]);
    
            $invalidSeats = json_decode($room->invalid_seats, true) ?? [];
    
            for ($i = 1; $i <= $room->rows; $i++) {
                for ($j = 1; $j <= $room->columns; $j++) {
                    if ($applicantIndex >= $applicants->count()) {
                        Log::debug('All available applicants have been assigned.');
                        break 2; // Exit both loops
                    }
    
                    $seatId = "{$i}-" . chr(64 + $j); // Converts column number to letter
    
                    if (in_array($seatId, $invalidSeats)) {
                        // Skip deactivated seat
                        continue;
                    }
    
                    // Use the checkSeatAvailability function
                    $applicant = $applicants->values()->get($applicantIndex);
                    $seatAvailable = $this->checkSeatAvailability($selectedRoom->id, $applicant->id, $exam->exam_start_time, $exam->exam_end_time, $i, $j);
    
                    Log::debug('Checking Seat Availability', [
                        'seatId' => $seatId,
                        'seatAvailable' => $seatAvailable
                    ]);
    
                    if ($seatAvailable) {
                        Seat::create([
                            'selected_room_id' => $selectedRoom->id,
                            'applicant_id' => $applicant->id,
                            'row' => $i,
                            'column' => $j,
                        ]);
    
                        $exam->applicants()->updateExistingPivot($applicant->id, ['status' => 'assigned']);
                        $selectedRoom->increment('applicant_seat_quantity');
    
                        Log::debug('Applicant Assigned to Seat', ['applicant' => $applicant]);
    
                        $applicantIndex++;
                    } else {
                        Log::debug('Seat is not available', ['row' => $i, 'column' => $j, 'room_id' => $room->id]);
                    }
                }
            }
        }
    
        if ($applicantIndex < $applicants->count()) {
            Log::warning('Not all applicants could be assigned to seats.', [
                'assigned' => $applicantIndex,
                'total_applicants' => $applicants->count(),
                'unassigned_applicants' => $applicants->count() - $applicantIndex
            ]);
        }
    
        Log::debug('Finished assigning applicants to seats');
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
                ->where('id', '!=', $exam->id)
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
    
            // Check if the applicant already has a seat
            $seat = Seat::where('applicant_id', $applicantId)
                ->where('selected_room_id', $selectedRoom->id)
                ->first();
    
            if ($seat) {
                // If the seat exists and row and column are null, update them
                if ($seat->row === null && $seat->column === null) {
                    $seat->row = $row;
                    $seat->column = $column;
                    $seat->save();
    
                    //Log::info('Updated existing seat with row and column', ['seat' => $seat]);
                } else {
                    // If the seat is already occupied, return an error
                    return response()->json(['success' => false, 'message' => 'Seat is already occupied.'], 400);
                }
            } else {
                // If the applicant does not have a seat, create a new one
                $seat = Seat::create([
                    'selected_room_id' => $selectedRoom->id,
                    'applicant_id' => $applicantId,
                    'row' => $row,
                    'column' => $column,
                ]);
    
                //Log::info('Created new seat', ['seat' => $seat]);
            }
    
            // Attach the applicant to the exam with status 'assigned'
            $exam->applicants()->syncWithoutDetaching([$applicantId => ['status' => 'assigned']]);
    
            // Decrement the selectedroom_valid_seat by 1
            $selectedRoom->increment('applicant_seat_quantity');
            $selectedRoom->save();
    
            return response()->json(['success' => true, 'message' => 'Applicant assigned to seat successfully.']);
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
                    if ($seat->row !== null && $seat->column !== null) {
                        // Update the pivot table to set status to not_assigned
                        if ($exam) {
                            $exam->applicants()->updateExistingPivot($seat->applicant_id, ['status' => 'not_assigned']);
                        }
    
                        // Remove the row and column from the seat
                        $seat->delete();

                        $selectedRoom->decrement('applicant_seat_quantity');
                        $selectedRoom->save();
    
                        // Log::info('Applicant removed from seat successfully');
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
        //Log::info('Starting to remove applicants from all seats in the rooms', ['request_data' => $request->all()]);
        
        try {
            $validatedData = $request->validate([
                'selectedRoom_id' => 'required|integer'
            ]);
        
            //Log::info('Request data validated successfully', ['validated_data' => $validatedData]);
        
            // Fetch the selected room with matching selectedRoom_id
            $selectedRoom = SelectedRoom::find($validatedData['selectedRoom_id']);
        
            if ($selectedRoom) {
                //Log::info('Selected room found', ['selected_room' => $selectedRoom]);
        
                // Fetch the associated exam
                $exam = Exam::find($selectedRoom->exam_id);
                if (in_array($exam->status, ['inprogress', 'finished', 'unfinished'])) {
                    return response()->json(['success' => false, 'message' => 'ไม่สามารถแก้ไขผู้เข้าสอบในวันเวลาดังกล่าว'], 400);
                }
                
                // Fetch all seats in the selected room
                $seats = Seat::where('selected_room_id', $selectedRoom->id)->get();
                //Log::info('Seats found in the selected room', ['seats' => $seats]);
        
                // Loop through all seats to remove applicants
                foreach ($seats as $seat) {
                    // Ensure seat has an applicant assigned
                    if ($seat->row !== null && $seat->column !== null) {
                        //Log::info('Removing applicant from seat', ['seat' => $seat]);
                        
                        // Update the pivot table to set status to not_assigned
                        $exam->applicants()->updateExistingPivot($seat->applicant_id, ['status' => 'not_assigned']);
        
                        // Remove the row and column from the seat
                        $seat->delete();
        
                        // Increment the selectedroom_valid_seat by 1
                        $selectedRoom->decrement('applicant_seat_quantity');
                        $selectedRoom->save();
                    } else {
                        Log::warning('No row and column assigned to this seat', ['seat' => $seat]);
                    }
                }
        
                return response()->json(['success' => true, 'message' => 'Applicants removed from seats successfully.']);
            } else {
                Log::warning('No selected room found with matching selectedRoom_id', ['selectedRoom_id' => $validatedData['selectedRoom_id']]);
                return response()->json(['success' => false, 'message' => 'No selected room found with matching selectedRoom_id.'], 404);
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


    public function assignAllApplicantsToSeats(Request $request)
    {
        $validatedData = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'room_id' => 'required|exists:exam_room_information,id',
            'direction' => 'required|string|in:left-to-right,right-to-left,alternate-left-right,alternate-right-left,top-to-bottom,bottom-to-top,alternate-top-bottom,alternate-bottom-top',
            'start_seat' => 'required|string'
        ]);
    
        $examId = $validatedData['exam_id'];
        $roomId = $validatedData['room_id'];
        $direction = $validatedData['direction'];
        $startSeat = $validatedData['start_seat'];
    
        $exam = Exam::findOrFail($examId);
        $room = ExamRoomInformation::findOrFail($roomId);
    
        // Fetch all applicants for the exam
        $applicants = $exam->applicants()->wherePivot('status', 'not_assigned')->get();
    
        if ($applicants->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No applicants to assign.'], 400);
        }
    
        $seatsArray = [];
        for ($i = 0; $i < $room->rows; $i++) {
            for ($j = 0; $j < $room->columns; $j++) {
                $seatsArray[] = ['row' => $i + 1, 'column' => $j + 1];
            }
        }
    
        // Find the index of the start seat
        $startSeatRow = intval(explode('-', $startSeat)[0]);
        $startSeatColumn = ord(explode('-', $startSeat)[1]) - 64;
        $startSeatIndex = array_search(['row' => $startSeatRow, 'column' => $startSeatColumn], $seatsArray);
    
        // Reorder the seatsArray to start from the start seat
        $seatsArray = array_merge(array_slice($seatsArray, $startSeatIndex), array_slice($seatsArray, 0, $startSeatIndex));
    
        // Sort seats based on the selected direction
        switch ($direction) {
            case 'right-to-left':
                $seatsArray = $this->sortSeatsRightToLeft($seatsArray, $room->rows, $room->columns);
                break;
            case 'alternate-left-right':
                $seatsArray = $this->sortSeatsAlternateLeftRight($seatsArray, $room->rows, $room->columns);
                break;
            case 'alternate-right-left':
                $seatsArray = $this->sortSeatsAlternateRightLeft($seatsArray, $room->rows, $room->columns);
                break;
            case 'top-to-bottom':
                $seatsArray = $this->sortSeatsTopToBottom($seatsArray, $room->rows, $room->columns);
                break;
            case 'bottom-to-top':
                $seatsArray = $this->sortSeatsBottomToTop($seatsArray, $room->rows, $room->columns);
                break;
            case 'alternate-top-bottom':
                $seatsArray = $this->sortSeatsAlternateTopBottom($seatsArray, $room->rows, $room->columns);
                break;
            case 'alternate-bottom-top':
                $seatsArray = $this->sortSeatsAlternateBottomTop($seatsArray, $room->rows, $room->columns);
                break;
            // Default is left-to-right, no need to sort
        }
    
        $applicantIndex = 0;
        $selectedRoom = SelectedRoom::firstOrCreate(['room_id' => $room->id, 'exam_id' => $exam->id]);
    
        $invalidSeats = json_decode($room->invalid_seats, true) ?? [];
    
        foreach ($seatsArray as $seat) {
            if ($applicantIndex >= count($applicants)) {
                break;
            }
    
            $seatId = "{$seat['row']}-" . chr(64 + $seat['column']);
            if (in_array($seatId, $invalidSeats)) {
                // Skip deactivated seat
                continue;
            } 
    
            // Skip rows and columns before the start seat
            if ($direction === 'top-to-bottom' || $direction === 'bottom-to-top' || $direction === 'alternate-top-bottom' || $direction === 'alternate-bottom-top') {
                // Handle vertical cases
                if ($seat['column'] < $startSeatColumn || ($seat['column'] == $startSeatColumn && $seat['row'] < $startSeatRow)) {
                    continue;
                }
            } else {
                // Handle horizontal cases
                if ($seat['row'] < $startSeatRow || ($seat['row'] == $startSeatRow && $seat['column'] < $startSeatColumn)) {
                    continue;
                }
            }

            $applicant = $applicants->values()->get($applicantIndex);
            $seatAvailable = $this->checkSeatAvailability($selectedRoom->id, $applicant->id, $exam->exam_start_time, $exam->exam_end_time, $seat['row'], $seat['column']);
    
            if ($seatAvailable) {
                Seat::create([
                    'selected_room_id' => $selectedRoom->id,
                    'applicant_id' => $applicant->id,
                    'row' => $seat['row'],
                    'column' => $seat['column'],
                ]);
    
                $exam->applicants()->updateExistingPivot($applicant->id, ['status' => 'assigned']);
                $selectedRoom->increment('applicant_seat_quantity');
    
                $applicantIndex++;
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Applicants assigned to seats successfully.']);
    }
    

    private function sortSeatsRightToLeft($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($i = 0; $i < $rows; $i++) {
            $rowSeats = array_slice($seatsArray, $i * $columns, $columns);
            $rowSeats = array_reverse($rowSeats);
            $sortedSeats = array_merge($sortedSeats, $rowSeats);
        }
        return $sortedSeats;
    }

    private function sortSeatsAlternateLeftRight($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($i = 0; $i < $rows; $i++) {
            $rowSeats = array_slice($seatsArray, $i * $columns, $columns);
            if ($i % 2 == 1) {
                $rowSeats = array_reverse($rowSeats);
            }
            $sortedSeats = array_merge($sortedSeats, $rowSeats);
        }
        return $sortedSeats;
    }

    private function sortSeatsAlternateRightLeft($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($i = 0; $i < $rows; $i++) {
            $rowSeats = array_slice($seatsArray, $i * $columns, $columns);
            if ($i % 2 == 0) {
                $rowSeats = array_reverse($rowSeats);
            }
            $sortedSeats = array_merge($sortedSeats, $rowSeats);
        }
        return $sortedSeats;
    }

    private function sortSeatsTopToBottom($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($j = 0; $j < $columns; $j++) {
            for ($i = 0; $i < $rows; $i++) {
                $sortedSeats[] = $seatsArray[$i * $columns + $j];
            }
        }
        return $sortedSeats;
    }

    private function sortSeatsBottomToTop($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($j = 0; $j < $columns; $j++) {
            for ($i = $rows - 1; $i >= 0; $i--) {
                $sortedSeats[] = $seatsArray[$i * $columns + $j];
            }
        }
        return $sortedSeats;
    }

    private function sortSeatsAlternateTopBottom($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($j = 0; $j < $columns; $j++) {
            $columnSeats = [];
            for ($i = 0; $i < $rows; $i++) {
                $columnSeats[] = $seatsArray[$i * $columns + $j];
            }
            if ($j % 2 == 1) {
                $columnSeats = array_reverse($columnSeats);
            }
            $sortedSeats = array_merge($sortedSeats, $columnSeats);
        }
        return $sortedSeats;
    }

    private function sortSeatsAlternateBottomTop($seatsArray, $rows, $columns)
    {
        $sortedSeats = [];
        for ($j = 0; $j < $columns; $j++) {
            $columnSeats = [];
            for ($i = 0; $i < $rows; $i++) {
                $columnSeats[] = $seatsArray[$i * $columns + $j];
            }
            if ($j % 2 == 0) {
                $columnSeats = array_reverse($columnSeats);
            }
            $sortedSeats = array_merge($sortedSeats, $columnSeats);
        }
        return $sortedSeats;
    }


    public function assignApplicantToSeatWithNewLayouts($applicantId, $selectedRoomId, $newRows, $newColumns, $invalidSeatsParsed, &$seatIndex)
    {
        // Log::debug('Starting seat assignment', [
        //     'applicantId' => $applicantId,
        //     'selectedRoomId' => $selectedRoomId,
        //     'newRows' => $newRows,
        //     'newColumns' => $newColumns
        // ]);
    
        $totalSeats = $newRows * $newColumns;
        if ($seatIndex >= $totalSeats) {
            //Log::debug('No available seat for applicant', ['applicantId' => $applicantId]);
            return;
        }
    
        while ($seatIndex < $totalSeats) {
            $row = (int)($seatIndex / $newColumns) + 1;
            $col = ($seatIndex % $newColumns) + 1;
            $seatIndex++;
            $seat = ['row' => $row, 'column' => $col];
    
            if (!in_array($seat, $invalidSeatsParsed)) {
                //Log::debug('Checking seat', ['row' => $row, 'column' => $col]);
    
                try {
                    // Try to reuse an existing seat record with null row and column

                    $selectedRoom = SelectedRoom::find($selectedRoomId);
                    $exam = Exam::find($selectedRoom->exam_id);
                    $seatAvailable = $this->checkSeatAvailability($selectedRoomId, $applicantId, $exam->exam_start_time, $exam->exam_end_time, $seat['row'], $seat['column']);

                    // Log::debug('Checking Seat Availability', [
                    //     'seatId' => $seatId,
                    //     'seatAvailable' => $seatAvailable
                    // ]);
                    //Log::info($seatAvailable);

                    if ($seatAvailable) {

                        // Log::debug('Assigning Applicant', [
                        //     'applicantIndex' => $applicantIndex,
                        //     'applicant' => $applicant
                        // ]);

                        Seat::create([
                            'selected_room_id' => $selectedRoomId,
                            'applicant_id' => $applicantId,
                            'row' => $seat['row'],
                            'column' => $seat['column'],
                        ]);

                        $exam->applicants()->updateExistingPivot($applicantId, ['status' => 'assigned']);
                        $selectedRoom->increment('applicant_seat_quantity');
                        return;
                    }
                } catch (\Exception $e) {
                    Log::error('Error assigning seat', ['error' => $e->getMessage()]);
                }
            }
        }
    
        //Log::debug('Unable to assign seat for applicant', ['applicantId' => $applicantId]);
    }
    
    public function deleteExtraSeats($roomId, $newRows, $newColumns)
    {
        $totalNewSeats = $newRows * $newColumns;
    
        // Fetch the selected_room_ids for the given room
        $selectedRoomIds = DB::table('selected_rooms')
            ->where('room_id', $roomId)
            ->pluck('id');
    
        if ($selectedRoomIds->isEmpty()) {
            //Log::debug('No selected_room_id found for room_id', ['room_id' => $roomId]);
            return;
        }
    
        // Fetch all seats for the selected rooms
        $seatsToUpdate = DB::table('seats')
            ->whereIn('selected_room_id', $selectedRoomIds)
            ->get();
    
        $totalExistingSeats = $seatsToUpdate->count();
    
        //Log::debug('Total new seats', ['totalNewSeats' => $totalNewSeats]);
        //Log::debug('Total existing seats', ['totalExistingSeats' => $totalExistingSeats]);
    
        if ($totalExistingSeats > $totalNewSeats) {
            $extraSeats = $seatsToUpdate->splice($totalNewSeats);
    
            foreach ($extraSeats as $seat) {
                DB::table('seats')->where('id', $seat->id)->delete();
                // Log::debug('Deleted extra seat', [
                //     'seatId' => $seat->id,
                //     'applicantId' => $seat->applicant_id,
                //     'row' => $seat->row,
                //     'column' => $seat->column
                // ]);
            }
        } else {
            //Log::debug('No extra seats to delete');
        }
    }

    public function getFirstAvailableSeat($roomId)
    {
        // Fetch the selected room ID that corresponds to the given room ID
        $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
    
        if (!$selectedRoom) {
            //Log::info('No selected room found for room ID:', ['roomId' => $roomId]);
            return response()->json(['success' => false, 'message' => 'No selected room found for the given room ID.']);
        }
    
        // Fetch the exam details for time comparison
        $exam = Exam::findOrFail($selectedRoom->exam_id);
    
        // Fetch the occupied seats considering all exams at the same time in the same room
        $occupiedSeats = Seat::whereHas('selectedRoom.exam', function ($query) use ($exam, $roomId) {
            $query->where('room_id', $roomId)
                  ->where('exam_date', $exam->exam_date)
                  ->where('exam_start_time', '<=', $exam->exam_end_time)
                  ->where('exam_end_time', '>=', $exam->exam_start_time);
        })->get(['row', 'column']);
    
        if ($occupiedSeats->isEmpty()) {
            //Log::info('No occupied seats found in the Seat table for selected room ID:', ['selectedRoomId' => $selectedRoom->id]);
        } else {
            //Log::info('Occupied seats found:', $occupiedSeats->toArray());
        }
    
        // Map occupied seats to "row-column" format
        $occupiedSeatIds = $occupiedSeats->map(function ($seat) {
            return "{$seat->row}-" . chr(64 + $seat->column);
        })->toArray();
    
        //Log::info('Occupied seat IDs:', $occupiedSeatIds);
    
        // Fetch room details to iterate over rows and columns
        $room = ExamRoomInformation::findOrFail($roomId);
    
        // Iterate through each seat in the room and find the first available one
        for ($i = 1; $i <= $room->rows; $i++) {
            for ($j = 1; $j <= $room->columns; $j++) {
                $seatId = "{$i}-" . chr(64 + $j);
                //Log::info('Checking seat:', ['seatId' => $seatId]);
                if (!in_array($seatId, $occupiedSeatIds)) {
                    //Log::info('First available seat found:', ['seatId' => $seatId]);
                    return response()->json(['success' => true, 'firstAvailableSeat' => $seatId]);
                }
            }
        }
    
        //Log::info('No available seats found');
        return response()->json(['success' => false, 'message' => 'No available seats found.']);
    }

    public function checkSeatOccupied($roomId, $seatId)
    {
        list($row, $column) = explode('-', $seatId);
        $column = ord($column) - 64; // Convert column letter to number
    
        //Log::info('Checking if seat is occupied:', ['roomId' => $roomId, 'seatId' => $seatId, 'row' => $row, 'column' => $column]);
    
        // Fetch the selected room ID corresponding to the roomId
        $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
        if (!$selectedRoom) {
            //Log::info('No selected room found for room ID:', ['roomId' => $roomId]);
            return response()->json(['success' => false, 'message' => 'No selected room found for the given room ID.']);
        }
    
        // Check if the seat is occupied in the specific selected room
        $isOccupied = Seat::where('selected_room_id', $selectedRoom->id)
                          ->where('row', $row)
                          ->where('column', $column)
                          ->exists();
    
        if ($isOccupied) {
            //Log::info('Seat is occupied:', ['seatId' => $seatId, 'roomId' => $roomId]);
            return response()->json(['success' => false, 'message' => 'Seat is occupied']);
        }
    
        //Log::info('Seat is available:', ['seatId' => $seatId, 'roomId' => $roomId]);
        return response()->json(['success' => true, 'message' => 'Seat is available']);
    }
}
