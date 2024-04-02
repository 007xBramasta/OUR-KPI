<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DB::table('user')->pluck('id')->toArray();
        
        $departementsIds = DB::table('departements')->pluck('departements_id')->toArray();

        // Define array of laporan data
        $laporanData = [
            [
                'user_id' => $userIds[array_rand($userIds)],
                'departements_id' => $departementsIds[array_rand($departementsIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($laporanData as $laporan) {
            // Generate UUID for each laporan
            $uuid = Uuid::uuid4()->toString();

            DB::table('laporan')->insert([
                'laporan_id' => $uuid,
                'user_id' => $laporan['user_id'],
                'departements_id' => $laporan['departements_id'],
                'created_at' => $laporan['created_at'],
                'updated_at' => $laporan['updated_at'],
            ]);
        }
    }
}
