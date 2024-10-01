<?php

namespace App\Http\Requests\Partner;

use App\Enums\AdType;
use App\Enums\CompanyType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property        int         company_id
 * @property        int         type
 * @property        string      title
 * @property        int         months_valid
 * @property        string      caption
 * @property        string      company_type
 * @property        string      company_title
 * @property        string      company_address
 * @property        int         city_id
 * @property        string      company_website
 * @property        string      company_phone
 * @property        string      company_mobile_phone
 * @property        string      logo
 * @property        string      banner
 */
class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_admin() || is_partner();
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
            'caption.required' => 'Napišite tekst ako ste odabrali vrstu oglasa: Gold.',
        ];
    }

    /**
     * Return rules applicable to all ad types
     *
     * @return array
     */
    private function getBaseRules(): array
    {
        $typeValidation = $this->isMethod('PUT') ?
            [Rule::enum(AdType::class)] : ['required', Rule::enum(AdType::class)];

        return [
            'type' => $typeValidation,
            'title' => ['nullable', 'string:255'],
            'months_valid' => ['required', 'integer', 'in:1,3,6,12'],
            'company_type' => ['required', Rule::enum(CompanyType::class)],
            'company_title' => ['required', 'string:255'],
            'company_address' => ['required', 'string:512'],
            'company_phone' => ['nullable', 'string:64'],
            'company_mobile_phone' => ['nullable', 'string:64'],
            'company_website' => ['nullable', 'string:255'],
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
                'caption' => ['required','string','max:512'],
            ],
            default => []
        };
    }
}
