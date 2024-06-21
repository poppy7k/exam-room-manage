<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedRoom extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'room_id'];

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
}
