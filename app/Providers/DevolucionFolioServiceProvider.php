<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DevolucionFolioRepository;
use App\Interfaces\DevolucionFolioRepositoryInterface;

class DevolucionFolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // registrar
        $this->app->bind(DevolucionFolioRepositoryInterface::class, DevolucionFolioRepository::class);
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
