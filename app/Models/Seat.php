<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'selected_room_id', 
        'applicant_id', 
        'row', 
        'column',
    ];

    public function selectedRoom()
    {
        return $this->belongsTo(SelectedRoom::class, 'selected_room_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
}