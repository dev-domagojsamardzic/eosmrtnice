<?php

use App\Models\Post;
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
        Schema::create('posts_offers', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Post::class)->constrained();

            $table->string('number')->nullable(false);
            $table->unsignedInteger('quantity')->nullable(false);
            $table->unsignedDecimal('price')->nullable(false);
            $table->unsignedDecimal('net_total')->nullable(false);
            $table->unsignedDecimal('taxes')->nullable(false);
            $table->unsignedDecimal('total')->nullable(false);
            $table->date('valid_from')->nullable(false);
            $table->date('valid_until')->nullable(false);
            $table->boolean('confirmed')->default(false);
            $table->dateTime('sent_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_offers');
    }
};
