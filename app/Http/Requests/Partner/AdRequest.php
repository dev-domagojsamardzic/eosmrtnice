<?php

namespace App\Http\Requests\Partner;

use App\Enums\AdType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property        int     type
 * @property        int     months_valid
 */
class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_partner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(AdType::class)],
            'months_valid' => ['required', 'integer', 'in:3,6,9,12'],
        ];
    }
}
