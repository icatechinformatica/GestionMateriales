<?php

namespace App\Providers;

use App\Interfaces\DriverRepositoryInterface;
use App\Repositories\DriverRepository;
use Illuminate\Support\ServiceProvider;


class DriverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // boot
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
