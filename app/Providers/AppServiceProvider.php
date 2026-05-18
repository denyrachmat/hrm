<?php

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
        //URL::forceScheme('https');
        \Illuminate\Support\Facades\URL::forceRootUrl(env('APP_URL'));
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }
}