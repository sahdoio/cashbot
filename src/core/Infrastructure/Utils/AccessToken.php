<?php

namespace Core\Infrastructure\Utils;

use Core\Domain\Entities\User;
use Core\Domain\Repositories\AccessTokenContract;
use Firebase\JWT\JWT;

class AccessToken implements AccessTokenContract
{
    private string $tokenSecret;

    private string $tokenIssuer;

    private int $tokenExpiration;

    public function __construct()
    {
        $this->tokenSecret = config('access_token.secret');
        $this->tokenIssuer = config('access_token.issuer');
        $this->tokenExpiration = (int) config('access_token.expiration');
    }

    public function generate(User $userEntity): string
    {
        $payload = [
            'iss' => $this->tokenIssuer, // Issuer of the token
            'sub' => $userEntity->email, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + ($this->tokenExpiration * 24 * 60 * 60), // Expiration time in seconds
        ];

        // Encode the payload with the specified algorithm and secret
        return JWT::encode($payload, $this->tokenSecret, 'HS256');
    }
}
