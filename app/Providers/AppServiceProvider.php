<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


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
        // Fuerza https detrás de ngrok / proxies
        if (app()->environment('production') || str_contains(config('app.url'), 'ngrok')) {
            URL::forceScheme('https');
        }
    }
}
