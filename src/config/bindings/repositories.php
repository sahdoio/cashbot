<?php

return [
    \Core\Domain\Repositories\DbRepositoryContract::class => \Core\Infrastructure\Repositories\Eloquent\EloquentDbRepository::class,
];
