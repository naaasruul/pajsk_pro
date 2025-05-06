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
        Schema::table('extra_cocuricculum', function (Blueprint $table) {
            $table->foreignId('class_id')->after('student_id')->constrained('classrooms')->onDelete('cascade');
            // Add any other columns or modifications you need here
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extra_cocuricculum', function (Blueprint $table) {
            //
        });
    }
};
