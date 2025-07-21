<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Kontrak;
use App\Observers\KontrakObserver;

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
        Kontrak::observe(KontrakObserver::class);
    }
}
