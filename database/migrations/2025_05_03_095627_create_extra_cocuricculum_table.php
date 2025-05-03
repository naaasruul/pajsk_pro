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
        Schema::create('extra_cocuricculum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Foreign key for students
            $table->unsignedBigInteger('service_id')->nullable(); // Foreign key for services
            $table->unsignedBigInteger('special_award_id')->nullable(); // Foreign key for special awards
            $table->unsignedBigInteger('community_service_id')->nullable(); // Foreign key for community services
            $table->unsignedBigInteger('nilam_id')->nullable(); // Foreign key for special awards
            $table->unsignedBigInteger('timms_pisa_id')->nullable(); // Foreign key for special awards
            $table->integer('total_point')->default(0); // Total points
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('special_award_id')->references('id')->on('special_awards')->onDelete('set null');
            $table->foreign('community_service_id')->references('id')->on('community_services')->onDelete('set null');
            $table->foreign('nilam_id')->references('id')->on('nilams')->onDelete('set null');
            $table->foreign('timms_pisa_id')->references('id')->on('timms_and_pisa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_cocuricculum');
    }
};
