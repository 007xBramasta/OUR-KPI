<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\KlausulItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartementKlausulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departements = Departement::all();
        $klausulItem1 = KlausulItem::where('title', 'Terdapat kebijakan K3')->first();
        $klausulItem1->departements()->attach($departements);
        $klausulItem2 = KlausulItem::where('title', 'Kebijakan K3 dikomunikasikan')->first();
        $klausulItem2->departements()->attach($departements);
    }
}
