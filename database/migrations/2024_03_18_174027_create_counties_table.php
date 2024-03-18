<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private array $counties = [
        ['id' => 1, 'title' => 'Zagrebačka'],
        ['id' => 2, 'title' => 'Krapinsko-zagorska'],
        ['id' => 3, 'title' => 'Sisačko-moslavačka'],
        ['id' => 4, 'title' => 'Karlovačka'],
        ['id' => 5, 'title' => 'Varaždinska'],
        ['id' => 6, 'title' => 'Koprivničko-križevačka'],
        ['id' => 7, 'title' => 'Bjelovarsko-bilogorska'],
        ['id' => 8, 'title' => 'Primorsko-goranska'],
        ['id' => 9, 'title' => 'Ličko-senjska'],
        ['id' => 10, 'title' => 'Virovitičko-podravska'],
        ['id' => 11, 'title' => 'Požeško-slavonska'],
        ['id' => 12, 'title' => 'Brodsko-posavska'],
        ['id' => 13, 'title' => 'Zadarska'],
        ['id' => 14, 'title' => 'Osječko-baranjska'],
        ['id' => 15, 'title' => 'Šibensko-kninska'],
        ['id' => 16, 'title' => 'Vukovarsko-srijemska'],
        ['id' => 17, 'title' => 'Splitsko-dalmatinska'],
        ['id' => 18, 'title' => 'Istarska'],
        ['id' => 19, 'title' => 'Dubrovačko-neretvanska'],
        ['id' => 20, 'title' => 'Međimurska'],
        ['id' => 21, 'title' => 'Grad Zagreb'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counties', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
        });

        DB::table('counties')->insert($this->counties);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counties');
    }
};
