<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // Optional: Kung gusto mong makita ang lahat ng members under this type
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}