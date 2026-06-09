<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Member::class, 'member_ministries');
    }
}
