<?php

use App\Models\AdType;
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
        Schema::create('ad_types', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration_months');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();
        });

        $adTypes = config('eosmrtnice.products.ad_types');

        foreach ($adTypes as $type) {
            $adType = new AdType();
            $adType->title = $type['title'];
            $adType->duration_months = $type['duration_months'];
            $adType->price = $type['price'];
            $adType->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_types');
    }
};
