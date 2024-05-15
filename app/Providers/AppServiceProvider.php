<?php

namespace App\Providers;

use App\Services\Quotes\Manager as QuoteManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('quote_manager', function ($app) {
            return new QuoteManager($app);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
