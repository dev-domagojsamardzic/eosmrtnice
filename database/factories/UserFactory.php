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
            'address' => $this->faker->address(),
            'zipcode' => $this->faker->postcode(),
            'town' => $this->faker->city(),
            'email' => $this->faker->unique()->safeEmail(),
            'type' => $this->faker->randomElement([UserType::PARTNER, UserType::MEMBER]),
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
     * Creates user with type=partner.
     *
     * @return Factory
     */
    public function partner(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Partner',
                'last_name' => 'Partner',
                'email' => 'partner@email.com',
                'password' => Hash::make('partner'),
                'type' => UserType::PARTNER,
            ];
        });
    }

    /**
     * Creates user with type=member.
     *
     * @return Factory
     */
    public function member(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Member',
                'last_name' => 'Member',
                'email' => 'member@email.com',
                'password' => Hash::make('member'),
                'type' => UserType::MEMBER,
            ];
        });
    }
}
