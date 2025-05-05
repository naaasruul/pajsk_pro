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
        Schema::table('pajsk_assessments', function (Blueprint $table) {
            $table->foreignId('class_id')->after('student_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('club_id')->after('teacher_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('club_position_id')->after('club_id')->constrained('club_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pajsk_assessments', function (Blueprint $table) {
            $table->dropForeign(['class_id', 'club_id', 'club_position_id']);
            $table->dropColumn('club_position_id');
            $table->dropColumn('club_id');
            $table->dropColumn('class_id');
        });
    }
};
