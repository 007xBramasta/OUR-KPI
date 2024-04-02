<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departementsIds = DB::table('departements')->pluck('departements_id')->toArray(); 

        $usersData = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karyawan 1',
                'email' => 'karyawan1@example.com',
                'password' => bcrypt('password123'),
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karyawan 2',
                'email' => 'karyawan2@example.com',
                'password' => bcrypt('password123'),
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($usersData as $userData) {
           
            $uuid = Uuid::uuid4()->toString();

            DB::table('user')->insert([
                'id' => $uuid,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role'],
                'departements_id' => $departementsIds[array_rand($departementsIds)],
                'created_at' => $userData['created_at'],
                'updated_at' => $userData['updated_at'],
            ]);
        }
    }
}
