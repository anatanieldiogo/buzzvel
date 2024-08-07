<?php

namespace App\Providers;

use App\Models\Holiday;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('holiday-owner', function (User $user, Holiday $holiday) {
            return $user->id === $holiday->user_id;
        });
    }
}
