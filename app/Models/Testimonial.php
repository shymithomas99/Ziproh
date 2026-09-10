<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'type',
        'image',
        'title',
        'description',
        'name',
        'designation',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'type' => 'integer',
        'sort_order' => 'integer',
        'status' => Status::class,
    ];
}
