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
        Schema::create('item_offer', function (Blueprint $table) {
            $table->foreignIdFor(Offer::class)->constrained();
            $table->morphs('itemable');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_offer');
    }
};
