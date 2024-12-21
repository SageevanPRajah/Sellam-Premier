<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trailer_link',
        'duration',
        'release_date',
        'imdb_link',
        'active'
    ];
}
