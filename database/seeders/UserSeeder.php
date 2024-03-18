<?php

namespace Database\Seeders;

use App\Enums\UserType;
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
        // Admin
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Administratorović',
            'email' => 'admin@email.com',
            'type' => UserType::ADMIN,
            'sex' => 'M',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        // Partner
        DB::table('users')->insert([
            'first_name' => 'Partner',
            'last_name' => 'Partnerović',
            'email' => 'partner@email.com',
            'type' => UserType::PARTNER,
            'sex' => 'M',
            'email_verified_at' => now(),
            'password' => Hash::make('partner'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        // User
        DB::table('users')->insert([
            'first_name' => 'Korisnica',
            'last_name' => 'Korisniković',
            'email' => 'dokisb1001@gmail.com',
            'type' => UserType::MEMBER,
            'sex' => 'F',
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
