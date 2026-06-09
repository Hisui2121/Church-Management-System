<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'event_date',
        'event_time',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];
}
