<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Roles seeded
    const ADMIN = 1;
    const PASTOR = 2;
    const MEMBER = 3;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}