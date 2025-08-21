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
        Schema::create('games', function (Blueprint $table) {
          $table->id();
          $table->timestamps();
          $table->dateTime('startTime');
          $table->string('home');
          $table->string('away');
          $table->string('week');
          $table->string('spread');
          $table->string('over');
          $table->string('gameId');
          $table->string('homeFinal');
          $table->string('awayFinal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
