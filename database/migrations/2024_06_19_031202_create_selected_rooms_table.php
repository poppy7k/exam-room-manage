<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() 
    {
        Schema::create('selected_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('room_id');
            $table->integer('applicant_seat_quantity')->nullable();
            $table->integer('selectedroom_valid_seat')->nullable();
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('exam_room_information')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('selected_rooms');
    }
};
