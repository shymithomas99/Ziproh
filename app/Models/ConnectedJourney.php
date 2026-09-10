<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class ConnectedJourney extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'icon',
        'url',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'type' => 'integer',
        'sort_order' => 'integer',
        'status' => Status::class,
    ];
}
