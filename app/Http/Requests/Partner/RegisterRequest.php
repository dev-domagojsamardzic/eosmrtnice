<?php

namespace App\Http\Requests\Partner;

use App\Enums\CompanyType;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @property    string      first_name
 * @property    string      last_name
 * @property    string      email
 * @property    string      gender
 * @property    string      password
 * @property    string      confirm_password
 * -----------------------------------------
 * @property    int         company_type
 * @property    string      company_title
 * @property    string      company_address
 * @property    string      company_town
 * @property    string      company_zipcode
 * @property    int         county_id
 * @property    string      company_oib
 * @property    string      company_email
 * @property    string      company_phone
 * @property    string      company_mobile_phone
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
            'password' => ['required', 'confirmed', Password::defaults()],

            'company_type' => ['required', Rule::enum(CompanyType::class)],
            'company_title' => ['required', 'string', 'max:255'],
            'company_address' => ['nullable','string', 'max:512'],
            'company_town' => ['nullable','string', 'max:255'],
            'company_zipcode' => ['nullable','numeric'],
            'county_code' => ['required','exists:counties,id'],
            'company_oib' => ['required', 'numeric', 'digits:11'],
            'company_email' => ['nullable','string', 'email', 'max:255'],
            'company_phone' => ['nullable','string', 'max:64'],
            'company_mobile_phone' => ['nullable','string', 'max:64']
        ];
    }
}
