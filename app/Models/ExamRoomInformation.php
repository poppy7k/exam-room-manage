<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRoomInformation extends Model
{
    use HasFactory;

    protected $table = 'exam_room_information';

    protected $fillable = [
        // 'orders',
        'building_name',
        'building_code',
        'floor',
        'room',
        'rows',
        'columns',
        'valid_seat',
        'total_seat',
        'selected_seats',
    ];

    protected $casts = [
        'selected_seats' => 'array',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_code', 'building_code');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

}