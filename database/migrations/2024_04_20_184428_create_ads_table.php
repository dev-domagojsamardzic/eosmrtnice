<?php

use App\Enums\AdType;
use App\Enums\CompanyType;
use App\Models\City;
use App\Models\Company;
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
        Schema::create('ads', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(City::class);
            $table->unsignedTinyInteger('type')->default(AdType::STANDARD);
            $table->unsignedTinyInteger('company_type')->default(CompanyType::FUNERAL);
            $table->string('title')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('active')->default(false);
            $table->unsignedInteger('months_valid')->nullable(false)->default(1);

            $table->string('company_title', 256)->nullable(false)->default('');
            $table->string('company_address', 512)->nullable(false)->default('');
            $table->string('company_phone', 64)->nullable();
            $table->string('company_mobile_phone', 64)->nullable();
            $table->string('company_website', 256)->nullable();

            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('caption', 512)->nullable();

            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
