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

    // public function selectedRoom()
    // {
    //     return $this->belongsTo(SelectedRoom::class, 'selected_room_id','room_staff');
    // }
    // public function selectedRooms()
    // {
    //     return $this->belongsToMany(SelectedRoom::class, 'room_staff', 'staff_id', 'room_id')
    //                 ->withTimestamps();
    // }
    public function selectedRooms()
    {
        return $this->belongsToMany(SelectedRoom::class, 'room_staff')
            ->withPivot('exam_id')
            ->withTimestamps();
    }
}
