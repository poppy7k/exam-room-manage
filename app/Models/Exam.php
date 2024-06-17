<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam_list';

    protected $fillable = [
        // 'orders',
        'name',
        'exam_takers_quantity',
        'building_id',
        'room_id',
        'subject',
        'exam_date',
    ];
}
