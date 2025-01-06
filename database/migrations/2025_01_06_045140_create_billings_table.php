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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->date('billing_date')->default(DB::raw('CURRENT_DATE')); // Set today's date as default
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('movie_id');
            $table->string('movie_name');
            $table->string('seat_type');
            $table->integer('total_tickets');
            $table->integer('full_tickets');
            $table->integer('half_tickets');
            $table->decimal('total_price', 10, 2);

             // Foreign Keys
             $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
             $table->foreign('movie_id')->references('id')->on('shows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
