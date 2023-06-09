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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('start')->nullable();
            $table->string('end')->nullable();       
            $table->string('day');
            $table->string('section');
            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->foreignId('subject_teacher_id')->constrained('subject_teacher');
            $table->timestamps();

          
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
