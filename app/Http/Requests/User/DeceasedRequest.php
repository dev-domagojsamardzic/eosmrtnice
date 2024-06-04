<?php

namespace App\Http\Requests\User;

use App\Enums\Gender;
use App\Rules\CityBelongsToCounty;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property        string          image
 * @property        string          gender
 * @property        string          first_name
 * @property        string          last_name
 * @property        string          maiden_name
 * @property        string          date_of_birth
 * @property        string          date_of_death
 * @property        int             death_county_id
 * @property        int             death_city_id
 */
class DeceasedRequest extends FormRequest
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
            'gender' => ['required', Rule::enum(Gender::class)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'maiden_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'before:' . today()->toDateString()],
            'date_of_death' => ['required', 'before:' . today()->addDay()->toDateString()],
            'city_id' => ['required', 'exists:cities,id', new CityBelongsToCounty('county_id')],
            'county_id' => ['required','exists:counties,id'],
        ];
    }
}
