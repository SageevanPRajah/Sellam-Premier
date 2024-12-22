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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Date of the show
            $table->string('time'); // 30min time slot
            $table->string('movie_code'); // night or matnee like
            $table->string('movie_name'); // Name of the movie
            $table->string('movie_poster')->nullable(); // Store movie poster image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
