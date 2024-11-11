<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->where('type', UserType::PARTNER)->first();

        return [
            'user_id' => $user?->id,
            'title' => $this->faker->company(),
            'address' => $this->faker->address(),
            'town'  => $this->faker->city(),
            'zipcode' => $this->faker->postcode(),
            'oib' => '11765477895',
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'active' => true,
        ];
    }
}
