<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class WayOfWorking extends Model
{
    protected $fillable = [
        'title',
        'short_desc',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];
}
