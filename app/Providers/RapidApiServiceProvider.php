<?php

namespace App\Providers;

use App\Services\RapidApiService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RapidApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $currency_api_key = config('app.currency_api_key');
        
        logger('Rapid API', [$currency_api_key]);
        
        $this->app->bind(RapidApiService::class, function ($app) use ($currency_api_key) {
            return new RapidApiService($currency_api_key);
        });
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

}
