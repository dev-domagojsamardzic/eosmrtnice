<?php

use App\Models\County;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(County::class);
            $table->unsignedTinyInteger('type');
            $table->string('title');
        });

        $file = fopen(base_path('docs/RH_opcine_gradovi.csv'), 'rb');
        while (($row = fgetcsv($file)) !== FALSE) {
            DB::table('cities')->insert([
               'county_id' => $row[0],
               'type' => $row[1],
               'title' => $row[2],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
