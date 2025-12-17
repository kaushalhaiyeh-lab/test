<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Page;
use App\Models\Job;
use App\Policies\UserPolicy;
use App\Policies\PagePolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use App\Models\Service;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Page::class => PagePolicy::class,
        Job::class  => JobPolicy::class,
        Role::class => RolePolicy::class,
        Service::class => ServicePolicy::class,
    ];
    public function boot(): void
{
    Gate::before(function ($user, $ability) {
        return $user->hasRole('super_admin') ? true : null;
    });
}
    
}
