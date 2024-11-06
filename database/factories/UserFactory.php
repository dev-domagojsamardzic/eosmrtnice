<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'type' => UserType::MEMBER,
            'birthday' => $this->faker->dateTimeBetween('-45 years', '-20 years', 'Europe/Zagreb')->format('Y-m-d'),
            'gender' => $this->faker->randomElement([Gender::MALE, Gender::FEMALE]),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'active' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
