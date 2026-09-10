<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class CoreValue extends Model
{
    protected $fillable = [
        'title',
        'short_desc',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];
}