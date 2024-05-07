<?php

use App\Models\Offer;
use App\Models\Service;
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
        Schema::create('offer_service', function (Blueprint $table) {
            $table->foreignIdFor(Offer::class)->constrained();
            $table->foreignIdFor(Service::class)->constrained();
            $table->decimal('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_service');
    }
};
