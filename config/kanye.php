<?php


return [
    'api_token' => env('API_TOKEN', 'valid-token'),
    'quotes' => [
        'url' => env('KANYE_QUOTES_URL', 'https://api.kanye.rest'),
        'limit' => env('KANYE_QUOTES_LIMIT', 5),
    ]
];
