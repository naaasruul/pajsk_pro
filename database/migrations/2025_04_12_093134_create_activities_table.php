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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('placement_id')->nullable(); // FK for placement
            $table->unsignedBigInteger('involvement_id')->nullable(); // FK for involvement
            $table->string('category')->nullable();
            $table->string('activity_place')->nullable();
            $table->date('date_start')->nullable();
            $table->time('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
            $table->json('activity_teachers_id')->nullable(); // List of teacher IDs
            $table->json('activity_students_id')->nullable(); // List of student IDs
            $table->unsignedBigInteger('leader_id')->nullable(); // Leader ID
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('placement_id')->references('id')->on('placements')->onDelete('set null');
            $table->foreign('involvement_id')->references('id')->on('involvement_types')->onDelete('set null');
            $table->foreign('leader_id')->references('id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
