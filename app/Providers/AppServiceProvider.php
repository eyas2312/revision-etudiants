<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /** Application en français, fuseau horaire de Tunis. */
    public function boot(): void
    {
        config(['app.timezone' => 'Africa/Tunis']);
        date_default_timezone_set('Africa/Tunis');

        App::setLocale('fr');
        Carbon::setLocale('fr');
    }
}
