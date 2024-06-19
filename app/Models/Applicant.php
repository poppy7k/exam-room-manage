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
        'exam_room_information_id',
        'row',
        'column',
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class);
    }
    
}
