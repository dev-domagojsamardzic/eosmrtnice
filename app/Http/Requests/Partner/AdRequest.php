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
        return array_merge($this->getBaseRules(), $this->getAdTypeRules());
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'logo.required' => 'Postavite logo ako ste odabrali vrstu oglasa: Premium ili Gold.',
            'banner.required' => 'Postavite naslovnu sliku ako ste odabrali vrstu oglasa: Gold.',
            'caption.required' => 'Postavite naslov ako ste odabrali vrstu oglasa: Gold.',
        ];
    }

    /**
     * Return rules applicable to all ad types
     *
     * @return array
     */
    private function getBaseRules(): array
    {
        return [
            'type' => ['required', Rule::enum(AdType::class)],
            'months_valid' => ['required', 'integer', 'in:1,3,6,12'],
        ];
    }

    /**
     * Return rules applicable only to specific AdType
     *
     * @return array|array[]
     */
    private function getAdTypeRules(): array
    {
        return match ((int)$this->type) {
            2 => [
                'logo' => ['required'],
            ],
            3 => [
                'logo' => ['required'],
                'banner' => ['required'],
                'caption' => ['required','string','max:256'],
            ],
            default => []
        };
    }
}
