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
        Schema::create('extra_cocuricullums', function (Blueprint $table) {
            $table->id();
            $table->integer('service_point')->default(0);
            $table->integer('special_award_point')->default(0);
            $table->integer('community_service_point')->default(0);
            $table->integer('nilam_point')->default(0);
            $table->integer('timms_and_pisa_point')->default(0);
            $table->integer('total_point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_cocuricullums');
    }
};
