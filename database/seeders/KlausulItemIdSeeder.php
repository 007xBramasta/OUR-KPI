<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use Faker\Factory as Faker;

class KlausulItemIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $klausulIds = DB::table('klausuls')->pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            $randomKlausulId = $faker->randomElement($klausulIds);

            DB::table('klausul_items')->insert([
                'id' => Str::uuid(), 
                'klausul_id' => $randomKlausulId, 
            ]);
        }
    }
}
