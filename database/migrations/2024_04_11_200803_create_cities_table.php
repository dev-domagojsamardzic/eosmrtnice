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
            $table->string('title');
            $table->string('zipcode');
            $table->string('municipality');
        });

        $file = file_get_contents(base_path('docs/RH_naselja_gradovi.json'));
        $data = json_decode($file, true, 512, JSON_THROW_ON_ERROR);

        $data = array_map(static function ($record) {
            return [
                'title' => $record['city'],
                'zipcode' => $record['zipcode'],
                'municipality' => $record['municipality'],
                'county_id' => $record['county_code']
            ];
        },$data);

        DB::table('cities')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
