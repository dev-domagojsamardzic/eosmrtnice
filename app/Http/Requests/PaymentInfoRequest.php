<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_member();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['nullable', 'string', 'min:3', 'max:255'],
            'city' => ['nullable', 'string', 'min:3', 'max:255'],
            'zipcode' => ['nullable', 'numeric', 'digits:5'],
        ];
    }
}
