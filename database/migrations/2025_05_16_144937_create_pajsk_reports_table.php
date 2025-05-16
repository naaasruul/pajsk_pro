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
        Schema::create('pajsk_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classrooms')->onDelete('cascade'); // determine the year of the report and classroom
            $table->foreignId('extra_cocuricullum_id')->constrained('extra_cocuricculum')->onDelete('cascade'); // take extra cocu report for the current year and points
            $table->foreignId('pajsk_assessment_id')->constrained()->onDelete('cascade'); // take club ids and marks
            $table->decimal('gpa', 5, 2)->nullable(); // GPA calculation: (highest total marks + second highest total marks for each organization) / 2 [automatically set to cgpa if first year]    
            $table->decimal('cgpa', 5, 2)->nullable(); // CGPA calculation: (past year + current year cgpa)
            $table->decimal('cgpa_pctg', 5, 2)->nullable(); // take CGPA and 10% it, eg: 67.5 = 6.75
            $table->text('report_description')->nullable(); // report desc determined by the cgpa accumulated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pajsk_reports');
    }
};
