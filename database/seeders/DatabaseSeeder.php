<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            KlausulSeeder::class,
            DepartementsSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            KlausulItemIdSeeder::class,
            KlausulItemSeeder::class,
            PenilaianDataSeeder::class,
        ]);
    }
}
