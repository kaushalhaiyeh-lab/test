<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin']);
    }

    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin']);
    }

    public function update(User $user, User $model): bool
    {
        // Super admin can update anyone
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Admin can update HR only
        return $user->hasRole('admin') && $model->hasRole('hr');
    }

    public function delete(User $user, User $model): bool
    {
        // Only super admin can delete users
        return $user->hasRole('super_admin');
    }
}
