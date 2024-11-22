<?php

namespace Database\Factories;

use App\Enums\AdType;
use App\Enums\CompanyType;
use App\Models\Ad;
use App\Models\City;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::query()->inRandomOrder()->first();
        $city = City::query()->inRandomOrder()->first();
        $from = $this->faker->dateTimeBetween('-365 days', '-1 days', 'Europe/Zagreb');

        return [
            'company_id'            => $company?->id,
            'city_id'               => $city?->id,
            'type'                  => AdType::STANDARD,
            'company_type'          => $this->faker->randomElement([CompanyType::FUNERAL, CompanyType::MASONRY, CompanyType::FLOWERS]),
            'title'                 => $this->faker->sentence(),
            'approved'              => true,
            'active'                => true,
            'months_valid'          => $this->faker->randomElement([1,3,6,12]),
            'company_title'         => $this->faker->company(),
            'company_address'       => $this->faker->address(),
            'company_phone'         => $this->faker->randomElement([null, $this->faker->phoneNumber()]),
            'company_mobile_phone'  => $this->faker->phoneNumber(),
            'company_website'       => $this->faker->url(),
            'logo'                  => '',
            'banner'                => '',
            'caption'               => $this->faker->sentences($this->faker->numberBetween(1, 5), true),
            'valid_from'            => $from,
            'valid_until'           => $this->faker->dateTimeBetween('+365 days', '+450 days', 'Europe/Zagreb'),
            'expired_at'            => null,
            'created_at'            => $from,
        ];
    }

    /**
     * Indicate standard ad type
     */
    public function standard(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type'      => AdType::STANDARD,
                'logo'      => '',
                'banner'    => '',
            ];
        });
    }

    /**
     * Indicate premium ad type
     */
    public function premium(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type'      => AdType::PREMIUM,
                'logo'      => '',
                'banner'    => '',
            ];
        });
    }

    /**
     * Indicate gold ad type
     */
    public function gold(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type'      => AdType::GOLD,
                'logo'      => '',
                'banner'    => '',
            ];
        });
    }

    /**
     * Indicate ad for funeral company
     */
    public function funeral(): Factory
    {
        return $this->state(function (array $attributes) {

            $type = $this->faker->randomElement([AdType::STANDARD, AdType::PREMIUM, AdType::GOLD]);
            echo $type->value;
            $logo = $this->getLogo($type, CompanyType::FUNERAL);
            $banner = $this->getBanner($type, CompanyType::FUNERAL);

            return [
                'type'          => $type,
                'company_type'  => CompanyType::FUNERAL,
                'logo'          => $logo,
                'banner'        => $banner,
            ];
        });
    }

    /**
     * Indicate ad for funeral company
     */
    public function masonry(): Factory
    {
        return $this->state(function (array $attributes) {

            $type = $this->faker->randomElement([AdType::STANDARD, AdType::PREMIUM, AdType::GOLD]);
            $logo = $this->getLogo($type, CompanyType::MASONRY);
            $banner = $this->getBanner($type, CompanyType::MASONRY);

            return [
                'type'          => $type,
                'company_type'  => CompanyType::MASONRY,
                'logo'          => $logo,
                'banner'        => $banner,
            ];
        });
    }

    /**
     * Indicate ad for flowers company
     */
    public function flowers(): Factory
    {
        return $this->state(function (array $attributes) {

            $type = $this->faker->randomElement([AdType::STANDARD, AdType::PREMIUM, AdType::GOLD]);
            $logo = $this->getLogo($type, CompanyType::FLOWERS);
            $banner = $this->getBanner($type, CompanyType::FLOWERS);

            return [
                'type'          => $type,
                'company_type'  => CompanyType::FLOWERS,
                'logo'          => $logo,
                'banner'        => $banner,
            ];
        });
    }

    private function getLogo(AdType $adType, CompanyType $companyType): string
    {
        $image = match ($companyType) {
            CompanyType::FUNERAL => 'logo_default_funeral.png',
            CompanyType::MASONRY => 'logo_default_masonry.png',
            CompanyType::FLOWERS => 'logo_default_flowers.png',
            default => 'logo_default',
        };

        return match ($adType) {
            AdType::PREMIUM, AdType::GOLD => 'dummy/logos/' . $image,
            default => '',
        };
    }

    private function getBanner(AdType $adType, CompanyType $companyType): string
    {
        $image = match ($companyType) {
            CompanyType::FUNERAL => 'banner_default_funeral.png',
            CompanyType::MASONRY => 'banner_default_masonry.png',
            CompanyType::FLOWERS => 'banner_default_flowers.png',
            default => 'banner_default.png',
        };

        return match ($adType) {
            AdType::GOLD => 'dummy/banners/' . $image,
            default => '',
        };
    }
}
