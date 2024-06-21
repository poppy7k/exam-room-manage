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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->integer('row');
            $table->integer('column');
            $table->timestamps();
            $table->unsignedBigInteger('exam_id')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('seats');
    }
};
