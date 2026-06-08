<?php

namespace App\Policies;

use App\Models\MemberStatus;
use App\Models\User;

class MemberStatusPolicy
{
    /** Only admins can view / manage member statuses and their permissions */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool {
        return false;
    }
    public function view(User $user, MemberStatus $status): bool {
        return false;
    }
    public function create(User $user): bool {
        return false;
    }
    public function update(User $user, MemberStatus $status): bool {
        return false;
    }
    public function delete(User $user, MemberStatus $status): bool {
        return false;
    }
}