<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * `users` only holds login/auth concerns now. Church-profile data
     * (phone, birthday, address, baptism info, etc.) lives on the linked
     * `members` record — see the accessors below, which read through to
     * $this->member so existing code calling $user->phone, $user->birthday,
     * etc. keeps working without changes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'member_id',
        'member_status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->getRoleNames()->isEmpty()) {
                $user->assignRole('Guest');
            }
        });
    }

    // -----------------------------------------------------
    // RELATIONSHIPS
    // -----------------------------------------------------

    public function memberStatus()
    {
        return $this->belongsTo(MemberStatus::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function ministryNames(): string
    {
        return $this->member?->ministries
            ->pluck('name')
            ->join(', ') ?: '-';
    }

    // -----------------------------------------------------
    // PROFILE ACCESSORS
    // -----------------------------------------------------
    // These fields no longer exist as columns on `users` — they live on
    // the linked `members` record instead. Accessors keep $user->phone,
    // $user->birthday, etc. working everywhere they're already used in
    // the app. They simply return null for accounts with no linked member
    // (e.g. a staff-only login).

    public function getPhoneAttribute()
    {
        return $this->member?->contact_number;
    }

    public function getBirthdayAttribute()
    {
        return $this->member?->birthdate;
    }

    public function getSexAttribute()
    {
        return $this->member?->gender;
    }

    public function getStreetAttribute()
    {
        return $this->member?->street;
    }

    public function getHouseNoAttribute()
    {
        return $this->member?->houseNo;
    }

    public function getBarangayAttribute()
    {
        return $this->member?->barangay;
    }

    public function getCityAttribute()
    {
        return $this->member?->city;
    }

    public function getMemberTypeAttribute()
    {
        return $this->member?->memberType?->name;
    }

    public function getBaptismStatusAttribute()
    {
        return $this->member?->baptism_status;
    }

    public function getBaptismDateAttribute()
    {
        return $this->member?->baptism_date;
    }

    public function getMinistryInterestAttribute()
    {
        return $this->member?->ministry_interest;
    }

    // ----------------------------------------------------
    // ROLE HELPERS
    //-----------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isPastor(): bool
    {
        return $this->hasRole('Pastor');
    }

    public function isMember(): bool
    {
        return $this->hasRole('Member');
    }

    // ---------------------------------------------------
    // PERMISSION HELPERS
    // ---------------------------------------------------

    /**
     * Admins always have every permission.
     * Everyone else receives permissions assigned directly to their user account.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->hasPermissionTo($permission);
    }
}