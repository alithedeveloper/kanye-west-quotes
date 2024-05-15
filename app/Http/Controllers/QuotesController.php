<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuotesController extends Controller
{
    public function __invoke()
    {

        $responses = Http::pool(function (Pool $pool) {
            $results = [];
            for ($i = 0; $i <= 5; $i++) {
                $results[] = $pool->get('https://api.kanye.rest');
            }
            return $results;
        });

        $data = array_map(function ($response) {
            return $response->json('quote');
        }, $responses);

        return Response::ok($data);
    }
}
