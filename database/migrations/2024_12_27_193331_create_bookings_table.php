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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Date of the show
            $table->string('time'); // 30min time slot
            $table->unsignedBigInteger('movie_id'); // Changed to unsignedBigInteger for foreign key
            $table->string('movie_name'); // Name of the movie
            $table->string('seat_type'); 
            $table->string('seat_no');
            $table->string('seat_code');
            $table->string('phone')->default('Counter booking');
            $table->string('name')->default('Counter booking');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('shows')->onDelete('cascade'); // Added foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};