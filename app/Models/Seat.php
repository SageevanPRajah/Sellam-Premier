<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_code',
        'seat_no',
        'seat_type',
        'seat_letter',
        'seat_digit'
    ];
}
