<?php

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
        Schema::create('companies', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('title');
            $table->string('address')->nullable();
            $table->char('zipcode');
            $table->string('town');
            $table->char('oib',11)->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
