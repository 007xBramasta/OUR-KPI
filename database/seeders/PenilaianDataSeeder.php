<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Klausul;
use App\Models\KlausulItem;
use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PenilaianDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $laporan = Laporan::first();
        $klausul_items = KlausulItem::all();

        foreach($klausul_items as $item){
            Penilaian::create([
                'laporan_id' => $laporan->laporan_id,
                'klausul_item_id' => $item->id
            ]);
        }
    }
}
