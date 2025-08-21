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
        Schema::create('picks', function (Blueprint $table) {
          $table->id();
          $table->timestamps();
          $table->string('week');
          $table->float('over');
          $table->string('overId');
          $table->float('under');
          $table->string('underId');
          $table->float('favoriteSpread');
          $table->string('favoriteId');
          $table->string('favoriteTeam');
          $table->float('underdogSpread');
          $table->string('underdogId');
          $table->string('underdogTeam');
          $table->string('userId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picks');
    }
};
