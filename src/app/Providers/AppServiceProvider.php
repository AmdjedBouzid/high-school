<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User; // Ensure the User model exists in this namespace. If not, update the namespace accordingly.

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is-super-admin', function (User $user) {
            return strtolower($user->role->name) === 'super-admin';
        });
        Gate::define('admin-level', function (User $user) {
            $value = strtolower($user->role->name);
            return $value === 'admin' || $value === 'super-admin';
        });
        Gate::define('update-owner-level', function (User $user, User $target) {
            return $user->id === $target->id ||
                in_array(strtolower($user->role->name), ['admin', 'super-admin']);
        });
        Gate::define('owner-access', function (User $user, User $target) {
            return $user->id === $target->id ||
                in_array(strtolower($user->role->name), ['admin', 'super-admin']);
        });
    }
}
