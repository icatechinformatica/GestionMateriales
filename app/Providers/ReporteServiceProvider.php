<?php

namespace App\Providers;

use App\Interfaces\ReporteRepositoryInterface;
use App\Repositories\ReporteRepository;
use Illuminate\Support\ServiceProvider;

class ReporteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ReporteRepositoryInterface::class, ReporteRepository::class);
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
