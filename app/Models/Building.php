<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_th',
        'building_en',
        'building_image',
        'building_map_url'
    ];

    public function examRoomInformation()
    {
        return $this->hasMany(ExamRoomInformation::class, 'building_id', 'id');
    }
}
