<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'contact_number',
        'email',
        'address',
        'profile_photo',
        'member_status_id',
        'member_type_id',
        'baptism_id',
        'family_group_id',
        'date_joined',
    ];

    /**
     * Get the member's status
     */
    public function memberStatus()
    {
        return $this->belongsTo(MemberStatus::class);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}