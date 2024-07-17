<?php

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
        Schema::create('condolences', static function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('motive');
            $table->string('message', 2048)->nullable(false);

            $table->string('recipient_full_name', 256)->nullable(false);
            $table->string('recipient_address', 1024)->nullable(false);

            $table->string('sender_full_name', 256)->nullable(false);
            $table->string('sender_email', 128)->nullable(false);
            $table->string('sender_phone', 64)->nullable(false);
            $table->string('sender_address', 1024)->nullable(false);
            $table->string('sender_additional_info', 1024);

            $table->string('package_addon');

            $table->dateTime('paid_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condolences');
    }
};
