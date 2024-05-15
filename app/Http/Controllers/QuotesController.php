<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Services\Quotes\Manager;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class QuotesController extends Controller
{
    public function __invoke()
    {
        $manager = app('quote_manager');
        $data = $manager->driver()->getQuotes();

        return Response::ok($data);
    }
}
