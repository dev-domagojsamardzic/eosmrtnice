<?php

namespace Database\Seeders;

use App\Enums\CompanyType;
use App\Models\Company;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->create();
    }
}
