<?php

namespace App\Services\Quotes;

use App\Contracts\Quotable;

class CachedQuoteService implements Quotable
{
    public function __construct(
        protected Quotable $service
    )
    {
    }

    public function getQuotes(): array
    {
        $cache_key = config('kanye.cache.key');
        $cache_time = config('kanye.cache.ttl');

        return cache()->remember($cache_key, $cache_time, fn() => $this->service->getQuotes()) ?? [];
    }
}
