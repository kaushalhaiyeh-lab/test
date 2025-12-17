<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage_jobs');
    }

    public function view(User $user, Job $job): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage_jobs');
    }

    public function update(User $user, Job $job): bool
    {
        return $user->can('manage_jobs');
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->hasRole(['super_admin', 'admin']);
    }
}
