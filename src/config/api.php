<?php

return [
    'url' => env('COIN_API_URL', 'https://api.coingecko.com/api/v3/coins/markets'), // Default URL
    'key' => env('COIN_API_KEY', ''), // set in env file
    'jwt_secret' => env('JWT_SECRET', ''), // set in env file
    'jwt_alg' => env('JWT_ALG', 'HS256'),
];
