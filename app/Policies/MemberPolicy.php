<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\Role;
use App\Models\User;

class MemberPolicy
{
    /**
     * Admins bypass all policy.
     * Return true from before() grants every ability.
     */

    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null; // Continue to individual checks
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_members');
    }

    public function view(User $user, Member $member): bool
    {
        return $user->hasPermission('view_members');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create_members');
    }

    public function update(User $user, Member $member): bool
    {
        return $user->hasPermission('edit_members');
    }

    public function delete(User $user, Member $member): bool
    {
        return $user->hasPermission('delete_members');
    }
}