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
        Schema::create('offers', static function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable(false);
            $table->date('for_date')->nullable(false);
            $table->foreignIdFor(User::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedDecimal('net_total')->nullable(false);
            $table->unsignedDecimal('taxes')->nullable(false);
            $table->unsignedDecimal('total')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
