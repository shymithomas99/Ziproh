<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProofPointIntro extends Model
{
    protected $fillable = [
        'type',
        'small_title',
        'title',
    ];

    protected $casts = [
        'type' => 'integer',
    ];
}
