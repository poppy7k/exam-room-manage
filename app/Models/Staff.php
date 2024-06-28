<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'id_number',
        'name',
        'selected_room_id',
    ];

    public function selectedRooms()
    {
        return $this->belongsToMany(SelectedRoom::class, 'room_staff', 'staff_id', 'selected_room_id')->withPivot('exam_id');
    }
}
