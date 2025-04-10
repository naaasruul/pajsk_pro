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
        Schema::create('uniformed_bodies', function (Blueprint $table) {
            $table->id();
            $table->string('body_name');
            $table->string('category'); // kementerian, NGO, seni bela diri
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniformed_units');
    }
};
