<?php

namespace App\Rules;

use App\Models\City;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CityBelongsToCounty implements DataAwareRule, ValidationRule
{
    protected array $data = [];
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $city = City::query()->where('id', $value)->first();
        if ((int)$city?->county_id !== (int)$this->data['company_county_id']) {
            $fail(__('validation.county_in_city'));
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }
}
