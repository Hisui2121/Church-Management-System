<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
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
        'role_id',
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

    // -----------------------------------------------------
    // RELATIONSHIPS
    // -----------------------------------------------------

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

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
        return $this->role_id === Role::ADMIN;
    }

    public function isPastor(): bool
    {
        return $this->role_id === Role::PASTOR;
    }

    public function isMember(): bool
    {
        return $this->role_id === Role::MEMBER;
    }

    // ---------------------------------------------------
    // PERMISSION HELPERS
    // ---------------------------------------------------

    /**
     * Admins always have every permission.
     * Everyone inherits from their MemberStatus permissions JSON.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $permissions = $this->memberStatus?->permissions ?? [];

        return in_array($permission, $permissions);
    }

    public function can($ability, $arguments = []): bool
    {
        // Delegate to Laravel Gate Policies first, then fall back to the permission string stored on member status.
        if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->has($ability)) {
            return parent::can($ability, $arguments);
        }

        return $this->hasPermission($ability);
    }
}
