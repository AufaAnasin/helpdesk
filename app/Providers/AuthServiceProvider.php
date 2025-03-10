<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication/authorization services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
            return $user->hasRole('Admin');
        });

        Gate::define('access-client', function (User $user) {
            return $user->hasRole('Client');
        });
    }
}