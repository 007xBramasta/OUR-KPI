<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departements = Departement::all();

        foreach($departements as $index => $departement){
            User::create([
                "name" => "Admin Departement $departement->departements_name",
                'email' => 'admin'. $index. '@mail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'departements_id' => $departement->departements_id
            ]);
        }
    }
}
