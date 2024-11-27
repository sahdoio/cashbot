<?php

namespace Core\Application\UseCases\Auth;

use Core\Application\Utils\BaseDTO;

class AuthenticationInputDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
