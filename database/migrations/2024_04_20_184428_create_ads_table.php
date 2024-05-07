<?php

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
            $table->unsignedTinyInteger('type')->default(1);
            $table->boolean('approved')->default(false);
            $table->boolean('active')->default(false);
            $table->unsignedInteger('months_valid')->nullable(false)->default(1);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->string('banner',256)->nullable();
            $table->string('caption', 256)->nullable();
            $table->boolean('expired')->default(false);
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
