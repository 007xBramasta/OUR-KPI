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
            DepartementsSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            KlausulKlausulItemSeeder::class,
            PenilaianDataSeeder::class,
        ]);
    }
}
