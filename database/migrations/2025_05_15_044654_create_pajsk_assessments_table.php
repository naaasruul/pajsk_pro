<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pajsk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classrooms')->onDelete('cascade');
            $table->json('teacher_ids')->nullable();
            $table->json('club_ids')->nullable();
            $table->json('club_position_ids')->nullable();
            $table->json('service_contribution_ids')->nullable();
            $table->json('attendance_ids')->nullable();
            $table->json('commitment_ids')->nullable();
            // $table->json('involvement_ids'); 
            $table->json('achievement_ids');
            $table->json('achievements_activity_ids'); 
            $table->json('placement_ids');
            $table->json('placements_activity_ids'); 
            // $table->json('service_ids')->nullable();
            $table->json('total_scores')->nullable();
            $table->json('percentages')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pajsk_assessments');
    }
};
