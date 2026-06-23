<?php

namespace App\Policies;

use App\Models\Commission;
use App\Models\User;

class CommissionPolicy
{
    public function update(User $user, Commission $commission): bool
    {
        return $user->isAdmin() || $commission->user_id === $user->id;
    }

    public function delete(User $user, Commission $commission): bool
    {
        return $user->isAdmin() || $commission->user_id === $user->id;
    }
}
