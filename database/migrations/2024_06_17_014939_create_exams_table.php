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
            $table->string('department_name')->nullable();
            $table->integer('exam_takers_quantity')->default(0);
            $table->string('exam_position')->nullable();
            $table->string('subject')->nullable();
            $table->datetime('exam_date')->nullable();
            $table->datetime('exam_start_time')->nullable();
            $table->datetime('exam_end_time')->nullable();
            $table->string('organization')->nullable();
            $table->string('status')->default('pending');
            $table->integer('exam_recent_change')->default(0);
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
