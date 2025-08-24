<?php

namespace App\Domain\Users\Http\Requests;

use App\Domain\Users\Enums\Locale;
use App\Domain\Users\Rules\WeakPasswordRule;
use App\Interfaces\Http\Request\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed', new WeakPasswordRule()],
            'locale'    => ['nullable', new Enum(Locale::class)],
        ];
    }
}
