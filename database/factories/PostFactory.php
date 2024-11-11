<?php

namespace Database\Factories;

use App\Enums\PostSize;
use App\Enums\PostSymbol;
use App\Enums\PostType;
use App\Enums\UserType;
use App\Models\City;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $funeral_city_id = null;
        $funeral_county_id = null;

        $type = $this->faker->randomElement([PostType::DEATH_NOTICE, PostType::MEMORY, PostType::LAST_GOODBYE, PostType::THANK_YOU]);

        if ($type === PostType::DEATH_NOTICE) {
            $city = City::query()->inRandomOrder()->first();
            $funeral_city_id = $city?->id;
            $funeral_county_id = $city?->county_id;
        }

        $deceasedName = $this->faker->name();

        $startDate = $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d');
        $endDate = $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d');

        return [
            'user_id' => User::query()->where('type', UserType::MEMBER)->inRandomOrder()->first()?->id,
            'type' => $this->faker->randomElement([PostType::DEATH_NOTICE, PostType::MEMORY, PostType::LAST_GOODBYE, PostType::THANK_YOU]),
            'size' => $this->faker->randomElement([PostSize::SMALL, PostSize::MEDIUM, PostSize::LARGE]),
            'funeral_city_id' => $funeral_city_id,
            'funeral_county_id' => $funeral_county_id,
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'is_framed' => $this->faker->randomElement([0, 1]),
            'image' => $this->faker->randomElement([
                'images/posts/default_person_m.jpg',
                'images/posts/default_person_f.jpg',
            ]),
            'symbol' => $this->faker->randomElement([PostSymbol::NONE, PostSymbol::CROSS, PostSymbol::DOVE, PostSymbol::MOON_STAR, PostSymbol::OLIVE_BRANCH, PostSymbol::STAR_OF_DAVID]),
            'deceased_full_name_lg' => $deceasedName,
            'slug' => Str::slug($deceasedName),
            'deceased_full_name_sm' => $deceasedName,
            'lifespan' => '1985. - 2023.',
            'intro_message' => $this->faker->paragraph(3),
            'main_message' => $this->faker->paragraph(7),
            'signature' => $this->faker->text(80),
            'is_active' => 1,
            'is_approved' => 1,
            'candles' => $this->faker->numberBetween(0, 520)
        ];
    }
}
