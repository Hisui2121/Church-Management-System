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
 * @property string|null $street
 * @property string|null $houseNo
 * @property string|null $barangay
 * @property string|null $city
 * @property string|null $profile_photo
 * @property int|null $member_status_id
 * @property int|null $member_type_id
 * @property string|null $baptism_status
 * @property string|null $baptism_date
 * @property string|null $ministry_interest
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
        'street',
        'houseNo',
        'barangay',
        'city',
        'profile_photo',
        'member_status_id',
        'member_type_id',
        'baptism_status',
        'baptism_date',
        'ministry_interest',
        'date_joined',
    ];

    /**
     * Get the member's status
     */
    public function memberStatus()
    {
        return $this->belongsTo(MemberStatus::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function ministries()
    {
        return $this->belongsToMany(Ministry::class, 'member_ministries')
            ->withPivot(['joined_at', 'role'])
            ->withTimestamps();
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Alias so views can use $member->name, matching how the rest of the
     * app refers to a person, without duplicating the value in storage.
     */
    public function getNameAttribute()
    {
        return $this->full_name;
    }

    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id');
    }

    /**
     * Get the member's primary ministry role
     */
    public function getPrimaryRoleAttribute()
    {
        return $this->ministries()->first()?->pivot?->role ?? null;
    }

    /**
     * Get comma-separated ministry names
     */
    public function getMinistryNamesAttribute()
    {
        return $this->ministries->pluck('name')->join(', ') ?: '—';
    }
}