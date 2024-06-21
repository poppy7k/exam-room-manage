<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'applicant_id', 'row', 'column' ,'exam_id'
    ];

    public function room()
    {
        return $this->belongsTo(ExamRoomInformation::class, 'room_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
}
