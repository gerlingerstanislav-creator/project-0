<?php

return [
    'default' => env('TRANSLATOR_DEFAULT', 'libretranslate'),

    'translators' => [
        'libretranslate' => [
            'driver' => 'libretranslate',
            'base_url' => env('LIBRETRANSLATE_URL', 'http://127.0.0.1:5000'),
            'key' => env('LIBRETRANSLATE_API_KEY'),
        ],
    ],

    'cache' => [
        'enabled' => env('TRANSLATOR_CACHE', true),
        'store' => env('TRANSLATOR_CACHE_STORE'),
        'ttl' => env('TRANSLATOR_CACHE_TTL', 86400),
        'prefix' => 'translator',
    ],
];
