<?php

namespace Database\Seeders;

use App\Enums\CompanyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'user_id' => 2,
            'type' => CompanyType::FUNERAL,
            'title' => 'Pogrebno poduzeće Smrtić',
            'address' => 'Nikole Tesle 14',
            'city_id' => 6761,
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::table('companies')->insert([
            'user_id' => 2,
            'type' => CompanyType::MASONRY,
            'title' => 'Kameno poduzeće Masonić',
            'address' => 'Nikole Tesle 14',
            'city_id' => 5450,
            'county_id' => 12,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::table('companies')->insert([
            'user_id' => 2,
            'type' => CompanyType::FLOWERS,
            'title' => 'Cvjećarnica Maslačak',
            'address' => 'Nikole Tesle 14',
            'city_id' => 6761,
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 0,
            'created_at' => now(),
        ]);
        DB::table('companies')->insert([
            'user_id' => 2,
            'type' => CompanyType::FLOWERS,
            'title' => 'Pogrebno poduzeće',
            'address' => 'Nikole Tesle 22',
            'city_id' => 2587,
            'county_id' => 4,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::table('companies')->insert([
            'user_id' => 2,
            'type' => CompanyType::MASONRY,
            'title' => 'Kamenjarka',
            'address' => 'Nikole Tesle 14',
            'city_id' => 6761,
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 0,
            'created_at' => now(),
        ]);

        DB::table('companies')->insert([
            'user_id' => 3,
            'type' => CompanyType::FLOWERS,
            'title' => 'Cvjećarska radnja Bartina',
            'address' => 'Nikole Tesle 14',
            'city_id' => 6761,
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::table('companies')->insert([
            'user_id' => 3,
            'type' => CompanyType::FUNERAL,
            'title' => 'Pogrebno poduzeće Piramida',
            'address' => 'Nikole Tesle 14',
            'city_id' => 6761,
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
    }
}
