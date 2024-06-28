<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'department_name',
        'exam_position',
        'exam_date',
        'exam_start_time',
        'exam_end_time',
        'exam_takers_quantity',
        'organization',
        'status',
    ];

    public function selectedRooms()
    {
        return $this->hasMany(SelectedRoom::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'exam_id');
    }
}
