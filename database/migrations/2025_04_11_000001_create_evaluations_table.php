<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->decimal('attendance_score', 5, 2);
            $table->decimal('position_score', 5, 2);
            $table->decimal('commitment_score', 5, 2);
            $table->decimal('service_contribution_score', 5, 2);
            $table->decimal('total_score', 5, 2);
            $table->timestamps();
        });

        Schema::create('commitment_score_evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('commitment_score_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commitment_score_evaluation');
        Schema::dropIfExists('evaluations');
    }
};