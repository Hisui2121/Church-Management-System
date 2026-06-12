<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image_path
 * @property \Carbon\Carbon|null $event_date
 * @property string|null $event_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

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
