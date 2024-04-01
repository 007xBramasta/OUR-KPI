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

class DepartemenTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_departement_users_relation()
    {
        $departement = Departement::factory()->create([
            'departements_name' => "Finance",
        ]);


        $user = User::factory()->create([
            'name' => 'Marsel',
            'departements_id' => $departement->departements_id
        ]);

        self::assertInstanceOf(Collection::class, $departement->users);
        if ($departement->users instanceof Illuminate\Database\Eloquent\Collection) {
            foreach ($departement->users as $user) {
                $this->assertInstanceOf(User::class, $user);
            }
        }
    }

    public function test_departement_laporans_relation(){
        $klausul = Klausul::factory()->create();
        

        $departement = Departement::factory()->create([
            "departements_name" => "IT",
        ]);

        $user = User::factory()->create([
            "departements_id" => $departement->departements_id
        ]);

        $laporan = Laporan::create([
            "user_id" => $user->id,
            "departements_id" => $departement->departements_id
        ]);

        $penilaian = Penilaian::factory()->create([
            'klausul_id' => $klausul->klausul_id,
            'laporan_id' => $laporan->laporan_id
        ]);
        $rekomendasi = Rekomendasi::factory()->create([
            "laporan_id" => $laporan->laporan_id
        ]);


        self::assertInstanceOf(Collection::class, $departement->laporans);

        foreach($departement->laporans as $laporan){
            self::assertInstanceOf(Laporan::class, $laporan);
        }

    }


}
