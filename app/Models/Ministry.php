<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Ministry extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the members in this ministry
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_ministries')
            ->withPivot(['joined_at', 'role'])
            ->withTimestamps();
    }
}
