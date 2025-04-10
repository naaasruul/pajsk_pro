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
        Schema::create('placement_scores', function (Blueprint $table) {
            $table->id();
            $table->string('placement');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->string('score')->default('ongoing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_scores');
    }
};
