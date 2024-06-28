<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id', 
        'room_id', 
        'applicant_seat_quantity'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'selected_room_id');
    }
}
