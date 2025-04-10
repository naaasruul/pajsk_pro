<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementInvolvementTable extends Migration
{
    public function up()
    {
        Schema::create('achievement_involvement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->foreignId('involvement_id')->constrained()->onDelete('cascade');
            $table->integer('score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievement_involvement');
    }
}