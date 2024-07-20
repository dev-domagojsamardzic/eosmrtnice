<?php

namespace App\Http\Requests\Admin\Offers;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property            int             user_id
 * @property            int             post_id
 * @property            string          valid_from
 * @property            string          valid_until
 * @property            int             quantity
 * @property            float           price
 * @property            string          submit
 */
class PostOfferRequest extends FormRequest
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
            'valid_from' => ['required', 'date_format:d.m.Y.', 'after_or_equal:today', 'before:valid_until'],
            'valid_until' => ['required', 'date_format:d.m.Y.', 'after:valid_from'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric'],
        ];
    }
}
