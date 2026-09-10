<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class ServiceLine extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'icon',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'type' => 'integer',
        'status' => Status::class,
        'sort_order' => 'integer',
    ];
}
