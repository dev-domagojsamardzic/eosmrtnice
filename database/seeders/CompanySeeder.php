<?php

namespace Database\Seeders;

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
            'title' => 'Pogrebno poduzeće',
            'address' => 'Nikole Tesle 14',
            'town' => 'Zagreb',
            'zipcode' => '10000',
            'county_id' => 21,
            'oib' => '11899764352',
            'email' => 'kompanija@email.com',
            'phone' => '000339812',
            'mobile_phone' => '003876788943',
            'active' => 1
        ]);
    }
}
