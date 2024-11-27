<?php

declare(strict_types=1);

namespace App\Http\Auth;

use App\Http\Requests\BaseFormRequest;

class AuthRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
