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
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('achievement_id')->nullable()->after('involvement_id'); // Add the column
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('set null'); // Add the foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['achievement_id']); // Drop the foreign key
            $table->dropColumn('achievement_id'); // Drop the column
        });
    }
};
