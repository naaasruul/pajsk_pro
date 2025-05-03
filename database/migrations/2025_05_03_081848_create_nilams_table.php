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
        Schema::create('nilams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievement_id'); // Foreign key for achievements
            $table->unsignedBigInteger('tier_id'); // Foreign key for tiers
            // $table->string('name')->nullable();
            $table->integer('point')->nullable();
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
            $table->foreign('tier_id')->references('id')->on('tiers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilams', function (Blueprint $table) {
            $table->dropForeign(['achievement_id']);
            $table->dropForeign(['tier_id']);
        });
        Schema::dropIfExists('nilams');
    }
};