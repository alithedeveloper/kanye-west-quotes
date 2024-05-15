<?php


return [
    'cache' => [
        'key' => env('QUOTE_CACHE_KEY', 'kanye_quotes'),
        'enabled' => env('QUOTE_CACHE_ENABLED', true),
        'ttl' => env('QUOTE_CACHE_TTL', 60),
    ],
    'api_token' => env('API_TOKEN', 'valid-token'),
    'quotes' => [
        'url' => env('KANYE_QUOTES_URL', 'https://api.kanye.rest'),
        'limit' => env('KANYE_QUOTES_LIMIT', 5),
    ]
];
