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
            //
            $table->unsignedBigInteger('created_by')->nullable()->after('leader_id'); // Add the column
            $table->foreign('created_by')->references('id')->on('teachers')->onDelete('set null'); // Add the foreign key
        });
    }

    /**
     * Reverse the migrations.
      */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['created_by']); // Drop the foreign key
            $table->dropColumn('created_by'); // Drop the column
        });
    }
};
