<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'title' => 'Reklama tipa STANDARD',
            'price' => 50.00,
        ]);

        DB::table('services')->insert([
            'title' => 'Reklama tipa PREMIUM',
            'price' => 100.00,
        ]);

        DB::table('services')->insert([
            'title' => 'Reklama tipa GOLD',
            'price' => 150.00,
        ]);
    }
}
