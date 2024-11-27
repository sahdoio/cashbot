<?php

namespace Core\Domain\Entities;

class AccessToken
{
    const string SCHEMA = 'AccessToken';

    public function __construct(
        public string $id,
        public string $name,
        public string $token
    ) {}
}
