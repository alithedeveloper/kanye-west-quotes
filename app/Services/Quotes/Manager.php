<?php

namespace App\Services\Quotes;


use Illuminate\Support\Manager as LaravelManager;

class Manager extends LaravelManager
{
    public function getDefaultDriver(): string
    {
        return 'kanye';
    }

    public function createKanyeDriver(): KanyeQuoteService|CachedQuoteService
    {
        $service = new KanyeQuoteService();
        if (!config('kanye.cache.enabled')) {
            return $service;
        }
        return new CachedQuoteService($service);
    }
}
