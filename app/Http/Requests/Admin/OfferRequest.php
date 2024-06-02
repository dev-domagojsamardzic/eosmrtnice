<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property        string      valid_from
 * @property        string      valid_until
 * @property        string      submit
 */
class OfferRequest extends FormRequest
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
            'valid_from' => ['required', 'date_format:d.m.Y.', 'before:valid_until'],
            'valid_until' => ['required', 'date_format:d.m.Y.', 'after:valid_from'],
        ];
    }
}
