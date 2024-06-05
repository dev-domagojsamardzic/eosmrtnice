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

            $table->unsignedInteger('type');
            $table->date('starts_at')->nullable(false);
            $table->date('ends_at')->nullable(false);
            $table->string('symbol')->nullable();
            $table->boolean('is_framed')->default(false);
            $table->string('image')->nullable();
            $table->string('intro_message')->nullable();
            $table->string('main_message')->nullable();
            $table->string('signature')->nullable();
            $table->string('size')->nullable();

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
