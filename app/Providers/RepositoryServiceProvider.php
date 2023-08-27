<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FacturaRepositoryInterface;
use App\Repositories\FacturaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(FacturaRepositoryInterface::class, FacturaRepository::class);
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
