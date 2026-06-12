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
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'barangay',
        'street',
        'houseNo',
        'birthday',
        'sex',
        'phone',
        'member_type',
        'baptism_status',
        'baptism_date',
        'ministry_interest',
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
                $user->assignRoles('Member');
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
