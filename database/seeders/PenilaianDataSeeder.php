<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Klausul;
use App\Models\KlausulItem;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenilaianDataSeeder extends Seeder
{
    public function run()
    {
        $karyawans = User::where('role', '=', 'karyawan')->get();
        $klausuls = Klausul::all();
        $klausuls_items = KlausulItem::all();

        foreach ($karyawans as $karyawan) {
            for ($i = 1; $i <= 12; $i++) {
                $Laporan = Laporan::create([
                    'user_id' => $karyawan->id,
                    'departements_id' => $karyawan->departements_id,
                    'created_at' => Carbon::create(2023, $i, 1, 0, 0, 1, 'Asia/Jakarta'),
                    'updated_at' => Carbon::create(2023, $i, 1, 0, 0, 1, 'Asia/Jakarta'),
                ]);
                
                // buat penilaian untuk setiap klausul item dari laporan di atas
                foreach($klausuls_items as $item){
                    Penilaian::create([
                        'laporan_id' => $Laporan->laporan_id,
                        'klausul_item_id' => $item->id
                    ]);
                }

                // masukan data laporan dan klausul ke dalam pivot tabel
                foreach ($klausuls as $klausul) {
                    DB::table('klausuls_laporans')->insert([
                        'id' => Str::uuid(),
                        'laporan_id' => $Laporan->laporan_id,
                        'klausul_id' => $klausul->id
                    ]);
                }

            }
        }
    }
}
