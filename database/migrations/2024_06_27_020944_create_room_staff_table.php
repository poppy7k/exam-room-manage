<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('room_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('selected_room_id');
            $table->unsignedBigInteger('exam_id');
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->foreign('selected_room_id')->references('id')->on('selected_rooms')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('room_staff');
    }
};
