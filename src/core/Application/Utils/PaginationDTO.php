<?php

namespace Core\Application\Utils;

class PaginationDTO extends BaseDTO
{
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $perPage,
        public readonly ?int $previousPage,
        public readonly ?int $nextPage,
        public readonly int $firstPage,
        public readonly int $lastPage
    ) {}
}
