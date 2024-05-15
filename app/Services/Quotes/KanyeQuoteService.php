<?php

namespace App\Services\Quotes;

use App\Contracts\Quotable;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class KanyeQuoteService implements Quotable
{
    public function getQuotes(): array
    {
        $responses = Http::pool(function (Pool $pool) {
            return collect()->times(config('kanye.quotes.limit'), fn() => $pool->get(config('kanye.quotes.url')))->all();
        });

        return array_map(fn($response) => $response->json('quote'), $responses);
    }
}
