<?php

namespace Core\Infrastructure\Utils;

use Core\Domain\Utils\EncrypterContract;
use Illuminate\Support\Facades\Hash;

class Bcrypt implements EncrypterContract
{
    public function check(string $value, string $hashedValue): bool
    {
        if (Hash::check($value, $hashedValue)) {
            return true;
        }

        return false;
    }
}
