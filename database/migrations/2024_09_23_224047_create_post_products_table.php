<?php

use App\Models\PostProduct;
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
        Schema::create('post_products', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();
        });

        $products = config('eosmrtnice.products.post_products');

        foreach ($products as $product) {
            $postProduct = new PostProduct();
            $postProduct->title = $product['title'];
            $postProduct->price = $product['price'];
            $postProduct->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_products');
    }
};
