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
            $table->dateTime('valid_from')->nullable(false);
            $table->dateTime('valid_until')->nullable(false);
            $table->timestamps();
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
