<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        // Fix Migration Bug
        Schema::defaultStringLength(191);

        // Force HTTPS
        if(env('FORCE_HTTPS',false)) { 
            URL::forceScheme('https');
        }
    }
}
