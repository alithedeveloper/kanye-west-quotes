<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class QuotesController extends Controller
{
    public function __invoke()
    {
        $responses = Http::pool(function (Pool $pool) {
            return collect()->times(config('kanye.quotes.limit'), fn() => $pool->get(config('kanye.quotes.url')))->all();
        });
        $data = array_map(fn($response) => $response->json('quote'), $responses);

        return Response::ok($data);
    }
}
