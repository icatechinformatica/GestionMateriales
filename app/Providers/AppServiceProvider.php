<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // Configuración para fechas en español
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');

        Blade::directive('money', function ($amount) {
            return "<?php echo '$ ' .  number_format($amount, 2); ?>";
        });
        // forzar https en producción
        if ($this->app->environment('production')) {
            # forzamos el esquema a trabajar con https
            \URL::forceScheme('https');
        }
    }
}
