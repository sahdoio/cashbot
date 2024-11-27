<?php

namespace Core\Domain\Utils;

interface EncrypterContract
{
    public function check(string $value, string $hashedValue): bool;
}
