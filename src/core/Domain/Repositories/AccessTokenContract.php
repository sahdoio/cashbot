<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\User;

interface AccessTokenContract
{
    public function generate(User $userEntity): string;
}
