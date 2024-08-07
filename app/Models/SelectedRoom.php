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
        'applicant_seat_quantity',
        'selectedroom_valid_seat'
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

    public function applicants()
    {
        return $this->hasManyThrough(Applicant::class, Seat::class, 'selected_room_id', 'id', 'id', 'applicant_id');
    }

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'room_staff', 'selected_room_id', 'staff_id')->withPivot('exam_id');
    }
}
