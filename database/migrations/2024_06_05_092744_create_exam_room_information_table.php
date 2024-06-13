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
        Schema::create('exam_room_information', function (Blueprint $table) {
            $table->id();
            // $table->string('orders')->nullable();
            $table->string('building_name')->nullable();
            $table->string('building_code')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->integer('rows')->nullable();
            $table->integer('columns')->nullable();
            $table->integer('valid_seat')->nullable();
            $table->integer('total_seat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_room_information');
    }
};
