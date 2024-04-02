<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Klausul;
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
    public function run()
    {
        $departement = Departement::factory()->create();
        $user = \App\Models\User::factory()->create([
            'departements_id' => $departement->departements_id
        ]);
        $laporan = \App\Models\Laporan::factory()->create([
            'user_id' => $user->id,
            'departements_id' => $user->departements_id
        ]);
        Penilaian::insert([
            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 1,
                'klausul_id' => Klausul::skip(5)->first()->klausul_id
            ],

            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 0,
                'klausul_id' => Klausul::skip(4)->first()->klausul_id
            ],
            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 1,
                'klausul_id' => Klausul::skip(3)->first()->klausul_id
            ],
            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 1,
                'klausul_id' => Klausul::skip(2)->first()->klausul_id
            ],

            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 1,
                'klausul_id' => Klausul::skip(1)->first()->klausul_id
            ],
            [
                'penilaian_id' => \Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'penilaian_target' => 1,
                'penilaian_aktual' => 1,
                'penilaian_keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint saepe ex soluta, quisquam eos reprehenderit eveniet esse obcaecati amet cumque, debitis ut provident illo libero expedita explicabo. A, eos! A.',
                'disetujui' => 1,
                'klausul_id' => Klausul::first()->klausul_id
            ],
        ]);
    }
}
