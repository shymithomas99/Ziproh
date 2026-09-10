<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialIntro extends Model
{
    protected $fillable = [
        'type',
        'small_title',
        'title',
        'image',
    ];

    protected $casts = [
        'type' => 'integer',
    ];
}
