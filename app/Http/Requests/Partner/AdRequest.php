<?php

namespace App\Http\Requests\Partner;

use App\Enums\AdType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property        int         type
 * @property        int         months_valid
 * @property        string      caption
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
            'months_valid' => ['required', 'integer', 'in:1,3,6,12'],
            'caption' => ['required_if:type,3','string','max:256'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'caption.required_if' => 'Naslov je obavezan ako je vrsta oglasa: Gold',
        ];
    }
}
