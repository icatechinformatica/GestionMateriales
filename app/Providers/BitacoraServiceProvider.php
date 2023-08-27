<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BitacoraRepositoryInterface;
use App\Repositories\BitacoraRepository;

class BitacoraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(BitacoraRepositoryInterface::class, BitacoraRepository::class);
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
