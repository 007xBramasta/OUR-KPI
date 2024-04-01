<?php

namespace Tests\Unit;

use App\Models\Departement;
use App\Models\Klausul;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\Rekomendasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_laporan_penilaian_relation()
    {
        $klausul = Klausul::factory()->count(5)->create();
        
        $departement = Departement::factory()->create([
            'departements_name' => "Finance",
        ]);

        $user = User::factory()->create([
            "departements_id" => $departement->departements_id
        ]);
        
        $laporan = Laporan::create([
            "user_id" => $user->id,
            "departements_id" => $departement->departements_id
        ]);

        $penilaian0 = Penilaian::factory()->create([
            "klausul_id" => Klausul::skip(1)->first()->klausul_id,
            "laporan_id" => $laporan->laporan_id
        ]);

        $penilaian1 = Penilaian::factory()->create([
            "klausul_id" => Klausul::first()->klausul_id,
            "laporan_id" => $laporan->laporan_id
        ]);

        $penilaian2 = Penilaian::factory()->create([
            "klausul_id" => Klausul::skip(2)->first()->klausul_id,
            "laporan_id" => $laporan->laporan_id
        ]);

        $rekomendasi = Rekomendasi::create([
            'rekomendasi_name' => "ini rekomendasi",
            'laporan_id' => $laporan->laporan_id
        ]);

        self::assertInstanceOf(Collection::class, $laporan->penilaian);
        foreach($laporan->penilaian as $item){
            self::assertInstanceOf(Penilaian::class, $item);
        }
    }
}
