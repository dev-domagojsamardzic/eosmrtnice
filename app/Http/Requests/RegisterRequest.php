<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @property    string      first_name
 * @property    string      last_name
 * @property    string      email
 * @property    string      gender
 * @property    string      birthday
 * @property    string      password
 * @property    string      confirm_password
 */

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'gender' => ['required', 'in:m,f'],
            'birthday' => ['required', 'date', 'before:-18 years'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()],
        ];
    }

    public function messages(): array
    {
        return [
            'birthday.before' => 'Morate imati najmanje 18 godina kako biste se registrirali.'
        ];
    }
}
