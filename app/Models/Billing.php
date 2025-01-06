<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'movie_id',
        'movie_name',
        'date',
        'time',
        'seat_type',
        'total_tickets',
        'full_tickets',
        'half_tickets',
        'total_price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }
 
}
