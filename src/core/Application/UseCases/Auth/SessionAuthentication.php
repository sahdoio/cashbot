<?php

namespace Core\Application\UseCases\Auth;

use Core\Domain\Repositories\DbRepositoryContract;

class SessionAuthentication
{
    public function __construct(
        protected DbRepositoryContract $dbRepository
    ) {}

    public function exec(AuthenticationInputDTO $data): void
    {
        // TODO: Implement exec() method for session authentication
    }
}
