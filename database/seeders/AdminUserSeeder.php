<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Leon Rešetar',
            'email' => 'test@email.com',
            'type' => UserType::ADMIN,
            'email_verified_at' => now(),
            'password' => Hash::make('leonresetar2024'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
