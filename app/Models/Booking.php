<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'movie_id',
        'movie_name',
        'seat_type',
        'seat_no',
        'seat_code',
        'phone',
        'name',
        'status',
    ];

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

}
