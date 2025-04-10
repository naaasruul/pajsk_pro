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
            $table->foreignId('involvement_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_score_id')->constrained()->onDelete('cascade');
            $table->foreignId('placement_score_id')->constrained()->onDelete('cascade');
            $table->string('activity_place');
            $table->string('category');
            $table->dateTime('datetime_start');
            $table->dateTime('datetime_end');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
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
