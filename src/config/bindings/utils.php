<?php

return [
    \Core\Domain\Repositories\AccessTokenContract::class => \Core\Infrastructure\Utils\AccessToken::class,
    \Core\Domain\Utils\EncrypterContract::class => \Core\Infrastructure\Utils\Bcrypt::class,
];
