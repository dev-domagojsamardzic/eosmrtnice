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
            'town' => 'Novi Zagreb',
            'zipcode' => '10200',
            'city_id' => 556,
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
            'address' => 'Grgurevići',
            'town' => 'Grgurevići',
            'zipcode' => '35122',
            'city_id' => 277,
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
            'title' => 'Cvjećarna poslednji pozdrav',
            'address' => 'Smrtna zona 12',
            'town' => 'Zagreb',
            'zipcode' => '10000',
            'city_id' => 556,
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
            'address' => 'Ulica ratnih heroja 234',
            'town' => 'Karlovac',
            'zipcode' => '32800',
            'city_id' => 104,
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
            'title' => 'Klesarstvo Kamenjarka',
            'address' => 'Miroljuba Petrovića 27',
            'town' => 'Osijek',
            'city_id' => 344,
            'county_id' => 14,
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
            'title' => 'Cvjećarska radnja Cesarica',
            'address' => 'Put Olivera Dragojevića 7',
            'town' => null,
            'city_id' => 474,
            'county_id' => 17,
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
            'address' => 'Nikole Zrinskog 33',
            'town' => null,
            'city_id' => 279,
            'county_id' => 12,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1,
            'created_at' => now(),
        ]);
    }
}
