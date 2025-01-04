<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_type',
        'seat_logo',
        'movie_code',
        'full_price',
        'half_price',
    ];
}
