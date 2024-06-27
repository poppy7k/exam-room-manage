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
        'exam_date', 
        'exam_start_time', 
        'exam_end_time',
        'exam_valid_seat'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'room_id', 'room_id');
    }

    // public function staffs()
    // {
    //     return $this->belongsToMany(Staff::class, 'selected_room_id','room_staff');
    // }
    // public function staffs()
    // {
    //     return $this->belongsToMany(Staff::class, 'room_staff', 'room_id', 'staff_id')
    //                 ->withTimestamps();
    // }
    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'room_staff')
            ->withPivot('exam_id')
            ->withTimestamps();
    }
}
