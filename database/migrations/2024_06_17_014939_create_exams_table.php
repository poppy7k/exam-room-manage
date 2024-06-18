<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name')->nullable();//
            $table->string('department_name')->nullable();//
            $table->string('exam_takers_quantity')->nullable();
            $table->string('building_id')->nullable();
            $table->string('room_id')->nullable();
            $table->string('exam_position')->nullable();//
            $table->datetime('exam_date')->nullable();//
            $table->datetime('exam_start_time')->nullable();//
            $table->datetime('exam_end_time')->nullable();//
            $table->string('organization')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
