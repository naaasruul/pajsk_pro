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
        Schema::table('achievements', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn(['achievement_stage', 'achievement_placement', 'score']);

            // Add the new column for achievement name
            $table->string('achievement_name')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            // Re-add the dropped columns
            $table->string('achievement_stage')->nullable();
            $table->string('achievement_placement')->nullable();
            $table->string('score')->nullable();

            // Drop the achievement_name column
            $table->dropColumn('achievement_name');
        });
    }
};