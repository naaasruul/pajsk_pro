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
       Schema::create('segaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->tinyInteger('session'); // 1 or 2
            $table->date('date');
            $table->float('weight'); // KG
            $table->float('height'); // CM

            $table->integer('step_test_steps');
            $table->integer('step_test_score');
            $table->integer('push_up_steps');
            $table->integer('push_up_score');
            $table->integer('sit_up_steps');
            $table->integer('sit_up_score');
            $table->float('sit_and_reach');
            $table->float('sit_and_reach_score');

            $table->integer('total_score');
            $table->string('gred', 5);
            $table->string('bmi_status', 50);

            $table->timestamps();

            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segaks');
    }
};
