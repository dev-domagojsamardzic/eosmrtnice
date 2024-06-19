<?php

use App\Models\Deceased;
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
        Schema::create('posts', static function (Blueprint $table) {

            $table->id();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Deceased::class);

            // TODO: transform this into table
            $table->unsignedInteger('type');
            $table->unsignedInteger('size');
            $table->date('starts_at')->nullable(false);
            $table->date('ends_at')->nullable(false);
            $table->boolean('is_framed')->default(false);
            $table->string('image')->nullable();
            $table->string('symbol')->nullable();
            $table->string('deceased_full_name_lg', 128);
            $table->string('deceased_full_name_sm', 128)->nullable();
            $table->string('lifespan', 50);
            $table->string('intro_message', 1024)->nullable();
            $table->string('main_message', 2048)->nullable();
            $table->string('signature', 512)->nullable();



            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
