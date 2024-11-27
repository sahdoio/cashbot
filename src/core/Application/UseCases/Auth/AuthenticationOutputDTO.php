<?php

namespace Core\Application\UseCases\Auth;

use Core\Application\Utils\BaseDTO;
use Core\Domain\Entities\User;

class AuthenticationOutputDTO extends BaseDTO
{
    public function __construct(
        public readonly User   $user,
        public readonly string $token
    ) {}
}
