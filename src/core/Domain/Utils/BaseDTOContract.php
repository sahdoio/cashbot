<?php

namespace Core\Domain\Utils;

interface BaseDTOContract
{
    public function values(): array;

    /**
     * @return mixed
     */
    public function get(string $property);
}
