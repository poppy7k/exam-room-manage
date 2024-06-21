<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedRoom extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'room_id', 'exam_date', 'exam_start_time', 'exam_end_time'];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class, 'room_id');
    }

    public function applicants()
    {
        return $this->hasManyThrough(Applicant::class, Seat::class, 'room_id', 'id', 'room_id', 'applicant_id');
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'selected_room_id');
    }
}
