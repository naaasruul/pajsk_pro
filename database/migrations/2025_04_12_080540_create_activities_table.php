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
            $table->unsignedBigInteger('achievement_placement_id')->nullable(); // FK for placement
            $table->unsignedBigInteger('achievement_involvement_id')->nullable(); // FK for involvement
            $table->string('category')->nullable();
            $table->string('activity_place')->nullable();
            $table->date('date_start')->nullable();
            $table->time('time_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('time_end')->nullable();
            $table->unsignedBigInteger('leader_id')->nullable(); // Leader ID
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('achievement_placement_id')->references('id')->on('achievement_placement')->onDelete('set null');
            $table->foreign('achievement_involvement_id')->references('id')->on('achievement_involvement')->onDelete('set null');
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