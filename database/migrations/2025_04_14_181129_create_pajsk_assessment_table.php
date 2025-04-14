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
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->integer('attendance_score');
            $table->integer('position_score');
            $table->integer('involvement_score'); 
            $table->integer('commitment_score');
            $table->integer('service_score');
            $table->integer('placement_score');
            $table->integer('total_score');
            $table->decimal('percentage', 5, 2);
            $table->json('commitment_ids'); // Store selected commitment IDs
            $table->foreignId('service_contribution_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pajsk_assessments');
    }
};
