<?php

namespace Tests\Unit;

use App\Models\Departement;
use App\Models\Klausul;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\Rekomendasi;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user have relation to departements.
     *
     * @return void
     */
    public function test_user_has_departements()
    {
        $departement = Departement::factory()->create([
            'departements_name' => "Finance",
        ]);


        $user = User::factory()->create([
            'name' => 'Marsel',
            'departements_id' => $departement->departements_id
        ]);


        self::assertInstanceOf(Departement::class, $user->departement);
    }
}
