<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\HolidayRepositoryInterface;
use App\Repositories\HolidayRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
