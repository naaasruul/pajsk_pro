<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // JADUAL 7/8: jenis penglibatan, skor elemen penglibatan
    public function up(): void
    {
        Schema::create('involvement_types', function (Blueprint $table) {
            $table->id();
            $table->integer('type'); // 1 = Penglibatan I, 2 = Penglibatan II, 3 = Penglibatan III
            $table->string('description')->nullable(); // "penglibatan I/II/III"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('involvement_types');
    }
};
