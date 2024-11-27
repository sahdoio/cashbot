<?php

return [
    'secret' => env('ACCESS_TOKEN_SECRET'),
    'issuer' => env('ACCESS_TOKEN_ISSUER', 'vitrineia-core'),
    'expiration' => env('ACCESS_TOKEN_EXPIRATION', 7),
];
