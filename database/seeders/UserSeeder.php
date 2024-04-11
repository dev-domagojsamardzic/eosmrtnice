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
        // Admin
        DB::table('users')->insert([
            'id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Administratorović',
            'email' => 'admin@email.com',
            'type' => UserType::ADMIN,
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        // Partners
        DB::table('users')->insert([
            'id' => 2,
            'first_name' => 'Partner',
            'last_name' => 'Partner',
            'email' => 'partner@email.com',
            'type' => UserType::PARTNER,
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('partner'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'first_name' => 'Matej',
            'last_name' => 'Partner2',
            'email' => 'partner2@email.com',
            'type' => UserType::PARTNER,
            'gender' => Gender::FEMALE,
            'email_verified_at' => now(),
            'password' => Hash::make('partner'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'first_name' => 'Ivan',
            'last_name' => 'Partner3',
            'email' => 'partnerovski@email.com',
            'type' => UserType::PARTNER,
            'gender' => Gender::FEMALE,
            'active' => 0,
            'email_verified_at' => now(),
            'password' => Hash::make('partner'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        // Users
        DB::table('users')->insert([
            'id' => 5,
            'first_name' => 'Domagoj',
            'last_name' => 'Samardžić',
            'email' => 'dokisb1001@gmail.com',
            'type' => UserType::MEMBER,
            'gender' => Gender::FEMALE,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        DB::table('users')->insert([
            'id' => 6,
            'first_name' => 'Marko',
            'last_name' => 'Martić',
            'email' => 'user@email.com',
            'type' => UserType::MEMBER,
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        DB::table('users')->insert([
            'id' => 7,
            'first_name' => 'Antonela',
            'last_name' => 'Skorupski',
            'email' => 'user2@email.com',
            'type' => UserType::MEMBER,
            'gender' => Gender::FEMALE,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        DB::table('users')->insert([
            'id' => 8,
            'first_name' => 'Korisnik',
            'last_name' => 'Korisniković',
            'email' => 'user3@email.com',
            'type' => UserType::MEMBER,
            'gender' => Gender::MALE,
            'active' => 0,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        DB::table('users')->insert([
            'id' => 9,
            'first_name' => 'Andrija',
            'last_name' => 'Sivrić',
            'email' => 'user4@email.com',
            'type' => UserType::MEMBER,
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
