<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamRoomInformation;
use App\Models\Applicant;
class ApplicantController extends Controller
{

    public function getApplicantsWithoutSeats($roomId)
    {
        // Log::info('Fetching applicants without seats for room:', ['room_id' => $roomId]);
        $room = ExamRoomInformation::findOrFail($roomId);
        $applicantsWithoutSeats = Applicant::whereDoesntHave('seats', function($query) use ($roomId) {
            $query->where('room_id', $roomId);
        })->get();
        
        // Log::info('Applicants without seats:', $applicantsWithoutSeats->toArray());
        
        return response()->json($applicantsWithoutSeats);
    }
}
