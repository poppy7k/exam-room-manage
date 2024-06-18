<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'exam_name',
        'department_name',
        'exam_position',
        'exam_date',
        'exam_start_time',
        'exam_end_time',
        'exam_takers_quantity',
        'building_id',
        'room_id',
        'organization',
        'status',
    ];
}
