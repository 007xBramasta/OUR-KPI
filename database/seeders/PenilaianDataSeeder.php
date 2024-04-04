<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\KlausulItem;
use App\Models\Penilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenilaianDataSeeder extends Seeder
{
    public function run()
    {
        $laporanId = DB::table('laporan')->pluck('laporan_id')->toArray();
        $klausulItemId = DB::table('klausul_items')->pluck('id')->toArray();

        for ($i = 0; $i < 15; $i++) {
            DB::table('penilaians')->insert([
                'id' => Str::uuid(), 
                'klausul_item_id' => $klausulItemId[array_rand($klausulItemId)],
                'laporan_id' => $laporanId[array_rand($laporanId)],
                'target' => '1',
                'aktual' => '1',
                'keterangan' => 'Aman',
                'rekomendasi' => 'Rekomendasi di berikan',
                'disetujui' => 1,
            ]);
        }   
    }    
}
