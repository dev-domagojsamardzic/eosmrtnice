<?php

use App\Models\City;
use App\Models\County;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deceaseds', static function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('maiden_name')->nullable();
            $table->string('slug')->nullable(false);
            $table->enum('gender',['m', 'f'])->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->date('date_of_death')->nullable(false);
            $table->foreignIdFor(User::class)->nullable(false);
            $table->foreignIdFor(County::class, 'death_county_id')->nullable(false);
            $table->foreignIdFor(City::class, 'death_city_id')->nullable(false);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deceaseds');
    }
};
