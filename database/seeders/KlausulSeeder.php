<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klausul;

class KlausulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $klausuls = [
            [
                'name' => 'Pembangunan dan Pemeliharaan Komitmen',
            ],
            [
                'name' => 'Pembuatan dan Pendokumentasikan Rencana K3',
            ],
            [
                'name' => 'Pengendalian Perancangan',
            ],
            [
                'name' => 'Pengendalian Dokumen',
            ],
            [
                'name' => 'Pembelian dan Pengendalian Produk',
            ],
            [
                'name' => 'Keamanan Bekerja Berdasarkan SMK3',
            ],
            [
                'name' => 'Standar Pemantauan',
            ],
            [
                'name' => 'Pelaporan dan Perbaikan Kekurangan',
            ],
            [
                'name' => 'Pengelolaan Material dan Perpindahan',
            ],
            [
                'name' => 'Pengumpulan dan Penggunaan Data',
            ],
            [
                'name' => 'Pemeriksaan SMK3',
            ],
            [
                'name' => 'Pengembangan Keterampilan dan Kemampuan',
            ],
        ];

        foreach ($klausuls as $klausulData) {
            Klausul::create([
                'name' => $klausulData['name'],
            ]);
        }
    }
}
