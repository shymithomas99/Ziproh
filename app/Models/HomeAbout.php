<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class HomeAbout extends Model
{
    //  protected $table = 'home_about';

    protected $fillable = [
        'small_title',
        'title',
        'description',
        'image',
        'button_text',
        'button_url',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }
}
