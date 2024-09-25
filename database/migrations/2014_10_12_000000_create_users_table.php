<?php

use App\Enums\Gender;
use App\Enums\UserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('type')->default(UserType::MEMBER);
            $table->date('birthday')->nullable(false);
            $table->enum('gender',['m', 'f'])->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Create default Administrator
        DB::table('users')->insert([
            'id' => 1,
            'first_name' => 'Leon',
            'last_name' => 'Rešetar',
            'email' => 'admin@email.com',
            'type' => UserType::ADMIN,
            'birthday' => '1990-01-01',
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'first_name' => 'Domagoj',
            'last_name' => 'Samardžić',
            'email' => 'dev.domagojsamardzic@gmail.com',
            'type' => UserType::ADMIN,
            'birthday' => '1992-01-10',
            'gender' => Gender::MALE,
            'email_verified_at' => now(),
            'password' => Hash::make('dev.domagojsamardzic'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
