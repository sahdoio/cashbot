<?php

namespace Core\Domain\Entities;

class User
{
    const string SCHEMA = 'User';

    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $password
    ) {}
}
