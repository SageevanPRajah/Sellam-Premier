<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'movie_code',
        'movie_name',
        'poster'
    ];

    //fetch the movie poster based on the movie name
    public function getMoviePosterAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
