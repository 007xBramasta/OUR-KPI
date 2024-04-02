<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $klausulIds = DB::table('klausul')->pluck('klausul_id')->toArray();

        $laporanIds = DB::table('laporan')->pluck('laporan_id')->toArray();

        $penilaianData = [
            [
                'penilaian_target' => 1,
                'penilaian_aktual' => 'Aktual 1',
                'penilaian_keterangan' => 'Keterangan 1',
                'rekomendasi' => 'Rekomendasi 1',
                'disetujui' => true,
                'klausul_id' => $klausulIds[array_rand($klausulIds)],
                'laporan_id' => $laporanIds[array_rand($laporanIds)],
            ],
            [
                'penilaian_target' => 1,
                'penilaian_aktual' => 'Aktual 1',
                'penilaian_keterangan' => 'Keterangan 1',
                'rekomendasi' => 'Rekomendasi 2',
                'disetujui' => true,
                'klausul_id' => $klausulIds[array_rand($klausulIds)],
                'laporan_id' => $laporanIds[array_rand($laporanIds)],
            ],
            [
                'penilaian_target' => 1,
                'penilaian_aktual' => 'Aktual 1',
                'penilaian_keterangan' => 'Keterangan 1',
                'rekomendasi' => 'Rekomendasi 3',
                'disetujui' => true,
                'klausul_id' => $klausulIds[array_rand($klausulIds)],
                'laporan_id' => $laporanIds[array_rand($laporanIds)],
            ],
        ];

        foreach ($penilaianData as $penilaian) {
            $uuid = Uuid::uuid4()->toString();
        
            DB::table('penilaian')->insert([
                'penilaian_id' => $uuid,
                'penilaian_target' => $penilaian['penilaian_target'],
                'penilaian_aktual' => $penilaian['penilaian_aktual'],
                'penilaian_keterangan' => $penilaian['penilaian_keterangan'],
                'rekomendasi' => $penilaian['rekomendasi'],
                'disetujui' => $penilaian['disetujui'],
                'klausul_id' => $penilaian['klausul_id'],
                'laporan_id' => $penilaian['laporan_id'],
            ]);
        }
    }
}
