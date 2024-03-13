<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_admin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'address' => ['nullable','string', 'max:512'],
            'town' => ['nullable','string', 'max:255'],
            'zipcode' => ['nullable','numeric'],
            'oib' => ['nullable','numeric', 'digits:11'],
            'email' => ['nullable','string', 'email', 'max:255'],
            'phone' => ['nullable','string', 'max:64'],
            'mobile_phone' => ['nullable','string', 'max:64']
        ];
    }
}
