<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $birthdate
 * @property string $gender
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $address
 * @property string|null $profile_photo
 * @property int|null $member_status_id
 * @property int|null $member_type_id
 * @property int|null $baptism_id
 * @property int|null $family_group_id
 * @property string|null $date_joined
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read MemberStatus|null $memberStatus
 * @property-read string $full_name
 */

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