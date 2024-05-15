<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\Request;

class RefreshQuotesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cachedQuotesKey = config('kanye.cache.key');

        if (cache()->has($cachedQuotesKey)) {
            cache()->forget($cachedQuotesKey);
        }

        $manager = app('quote_manager');
        $data = $manager->driver()->getQuotes();

        return Response::ok(
            content: $data,
            message: 'Quotes cache has been refreshed.'
        );
    }
}
