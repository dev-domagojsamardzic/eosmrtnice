<?php

use App\Models\CondolenceAddon;
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
        Schema::create('condolence_addons', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();
        });

        $addons = config('eosmrtnice.products.condolences_addons');

        foreach ($addons as $addon) {
            $condolenceAddon = new CondolenceAddon();
            $condolenceAddon->title = $addon['title'];
            $condolenceAddon->price = $addon['price'];
            $condolenceAddon->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condolence_addons');
    }
};
