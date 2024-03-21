<?php

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
        Schema::create('companies', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->unsignedTinyInteger('type')->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('address')->nullable(false);
            $table->string('town')->nullable(false);
            $table->char('zipcode')->nullable(false);
            $table->foreignIdFor(County::class);
            $table->char('oib',11)->nullable(false);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
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
