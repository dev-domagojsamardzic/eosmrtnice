<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one partner, one member
        User::factory()->partner()->create();
        User::factory()->member()->create();
    }
}
