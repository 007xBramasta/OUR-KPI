<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DepartementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departementsData = [
            [
                'departements_name' => 'Tank Farm',
            ],
            [
                'departements_name' => 'Ref 1, 2 & batch',
            ],
            [
                'departements_name' => 'Finish Goodwarehouse',
            ],
            [
                'departements_name' => 'Utility'
            ],
            [
                'departements_name' => 'Margarine 1,2,3 &tining'
            ],
            [
                'departements_name' => 'FWGH Wahana'
            ],
            [
                'departements_name' => 'Maintenance'
            ],
            [
                'departements_name' => 'PLU Nilam'
            ],
            [
                'departements_name' => 'Hydrogenation'
            ],
            [
                'departements_name' => 'Fraksinasi 1'
            ],
            [
                'departements_name' => 'Laboratium QC'
            ],
            [
                'departements_name' => 'Serac,Pet,Canning & Pouching'
            ],
            [
                'departements_name' => 'Fasum'
            ],
            [
                'departements_name' => 'Fraksinasi 2'
            ],
            [
                'departements_name' => 'Fraksinasi 3'
            ],
            [
                'departements_name' => 'CAMS Warehouse'
            ],
            [
                'departements_name' => 'PT Wahana'
            ],
            [
                'departements_name' => 'Office',
            ]
        ];

        // Loop through departements data
        foreach ($departementsData as $departementData) {
            // Generate UUID for each departement
            $uuid = Uuid::uuid4()->toString();

            // Insert departement data with UUID into database
            DB::table('departements')->insert([
                'departements_id' => $uuid,
                'departements_name' => $departementData['departements_name'],
            ]);
        }
    }
}
