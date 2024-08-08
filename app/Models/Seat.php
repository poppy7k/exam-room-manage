<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'selected_room_id', 
        'applicant_id', 
        'row', 
        'column',
    ];

    public function selectedRoom()
    {
        return $this->belongsTo(SelectedRoom::class, 'selected_room_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public static function isSeatAvaliable($selectedRoomId, $applicantId, $startTime, $endTime, $row, $column)
    {
        $selectedRoomIds = Seat::pluck('selected_room_id')->unique();
        //Log::info('Selected Room Ids:', $selectedRoomIds->toArray());
    
        // Retrieve the room_id for a specific selected_room_id
        $selectedRoom = SelectedRoom::find($selectedRoomId);
        $roomId = $selectedRoom ? $selectedRoom->room_id : null;
        //Log::info('Room ID:', ['roomId' => $roomId]);
    
        $examIdsBySelectedRoom = SelectedRoom::whereIn('id', $selectedRoomIds)
            ->where('room_id', $roomId)
            ->pluck('exam_id', 'id'); // ดึง 'exam_id' เป็นค่าที่ดึงออกมา และ 'id' เป็นคีย์
    
        //Log::info('Exam IDs by Selected Room:', $examIdsBySelectedRoom->toArray());
    
        $matchingSelectedRoomIds = [];
        foreach ($examIdsBySelectedRoom as $selectedRoomId => $examId) {
            //Log::info("Exam ID check: $examId");
            $exam = Exam::find($examId);
    
            if ($exam) {
                $examStartTime = $exam->exam_start_time;
                $examEndTime = $exam->exam_end_time;
    
                if ($examStartTime < $endTime && $examEndTime > $startTime) {
                    $matchingSelectedRoomIds[] = $selectedRoomId;
                }
            }
        }
    
        //Log::info("Matching Selected Room IDs: ", $matchingSelectedRoomIds);
    
        // Query Seat model with matching selected_room_ids
        $seatsWithMatchingRooms = Seat::whereIn('selected_room_id', $matchingSelectedRoomIds)
            ->where('row', $row)
            ->where('column', $column)
            ->get();
    
        //Log::info('Seats with Matching Selected Room IDs:', $seatsWithMatchingRooms->toArray());
    
        // Check if there are any seats with the matching selected_room_id
        if ($seatsWithMatchingRooms->isNotEmpty()) {
            //Log::info('Seats found, indicating that the seat is not available.');
            return false; // Return false if seats are found
        }
    
        // If no matching seats are found, return true or proceed with other logic
        //Log::info('No seats found, the seat is available.');
        return true; // Or handle as needed
    }
}