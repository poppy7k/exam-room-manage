<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $table = 'applicants';

    protected $fillable = [
        'id_number',
        'id_card',
        'name',
        'degree',
        'position',
        'department',
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class, 'applicant_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class, 'exam_room_information_id');
    }
    
}
