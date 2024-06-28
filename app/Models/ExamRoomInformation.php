<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRoomInformation extends Model
{
    use HasFactory;

    protected $table = 'exam_room_information';

    protected $fillable = [
        'building_id',
        'floor',
        'room',
        'rows',
        'columns',
        'valid_seat',
        'total_seat',
        'invalid_seats',
    ];

    protected $casts = [
        'selected_seats' => 'array',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'room_id');
    }

    public function applicants()
    {
        return $this->hasManyThrough(Applicant::class, Seat::class, 'room_id', 'id', 'id', 'applicant_id');
    }

    public function selectedRooms()
    {
        return $this->hasMany(SelectedRoom::class, 'room_id');
    }

    public function exams()
    {
        return $this->hasManyThrough(Exam::class, SelectedRoom::class, 'room_id', 'id', 'id', 'exam_id');
    }
}