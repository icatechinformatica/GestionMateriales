<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FolioRepositoryInterface;
use App\Repositories\FolioRepository;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         // registrando la interface y el repositorio
         $this->app->bind(FolioRepositoryInterface::class, FolioRepository::class);
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
