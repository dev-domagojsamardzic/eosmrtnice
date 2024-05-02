<?php

namespace App\Http\Requests\Partner;

use App\Enums\CompanyType;
use App\Rules\CityBelongsToCounty;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read   int             id
 * @property        int             user_id
 * @property        string          title
 * @property        int             type
 * @property        string          address
 * @property        string          town
 * @property        string          zipcode
 * @property        string          oib
 * @property        int             city_id
 * @property        int             county_id
 * @property        string          email
 * @property        string          phone
 * @property        string          mobile_phone
 * @property        bool            active
 * @property        string          logo
 * @property        string          website
 */
class CompanyRequest extends FormRequest
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
            'type' => ['required', Rule::enum(CompanyType::class)],
            'title' => ['required', 'string', 'max:255'],
            'address' => ['nullable','string', 'max:512'],
            'town' => ['nullable','string', 'max:255'],
            'zipcode' => ['nullable','numeric', 'digits:5'],
            'city_id' => ['required', 'exists:cities,id', new CityBelongsToCounty('county_id')],
            'county_id' => ['required','exists:counties,id'],
            'oib' => ['required','numeric', 'digits:11'],
            'email' => ['nullable','string', 'email', 'max:255'],
            'phone' => ['nullable','string', 'max:64'],
            'mobile_phone' => ['nullable','string', 'max:64'],
            'website' => ['nullable', 'string', 'url:https', 'active_url'],
        ];
    }
}
