<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1) Fuerza HTTPS en local si el request viene detrás de proxy con HTTPS
        if (app()->environment('local')) {
            $xfp = request()->header('x-forwarded-proto');
            if ($xfp === 'https') {
                URL::forceScheme('https');
            }
        }

        // 2) Además, si APP_URL ya es https, fuerza https (útil para ngrok)
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
