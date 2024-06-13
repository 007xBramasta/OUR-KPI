<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\KlausulItem;
use Illuminate\Database\Seeder;

class DepartementKlausulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'Rencana kerja dan rencana khusus',
            'Informasi K3 dikomunikasikan',
            'Penetapan anggota penanganan keadaan darurat',
            'Seritifikasi pelatihan penanganan keadaan darurat',
            'Rencana kerja dan rencana khusus',
            'Informasi K3 dikomunikasikan',
            'Laporan Inspeksi K3',
            'Laporan unsafe condition',
            'Laporan nearmiss',
            'Laporan kecelakaan kerja',
            'Tim investigasi terlatih dan berkompeten',
            'Prosedur perancangan dan modifikasi'
        ];

        // Menghubungkan klausul yang pasti ada di semua departement
        $departements = Departement::all();
        $klausuls = KlausulItem::whereNotIn('title', $titles)->get();

        $departements->each(function ($departement) use ($klausuls) {
            $existingKlausuls = $departement->klausul_items->pluck('id')->toArray();
            $newKlausuls = $klausuls->whereNotIn('id', $existingKlausuls);
            $departement->klausul_items()->attach($newKlausuls);
        });

        // Menghubungkan klausul yang pasti ada di semua departement namun tidak ada di departement Maintenance
        $departementWithoutMaintenance = Departement::whereNotIn('departements_name', ['Maintenance'])->get();
        $departementWithoutMaintenance->each(function ($departement) use ($klausuls) {
            $existingKlausuls = $departement->klausul_items->pluck('id')->toArray();
            $newKlausuls = $klausuls->whereNotIn('id', $existingKlausuls);
            $departement->klausul_items()->attach($newKlausuls);
        });

        // Menghubungkan klausul yang hanya  ada di departement Office
        $departementOffice = Departement::where('departements_name', 'Office')->first();
        $klausulsOnlyOffice = KlausulItem::whereIn('title', [
            'Laporan kecelakaan kerja',
            'Tim investigasi terlatih dan berkompeten',
            'Rencana kerja dan rencana khusus',
            'Informasi K3 dikomunikasikan',
            'Prosedur perancangan dan modifikasi'
        ])->get();

        $existingKlausulsOffice = $departementOffice->klausul_items->pluck('id')->toArray();
        $newKlausulsOffice = $klausulsOnlyOffice->whereNotIn('id', $existingKlausulsOffice);
        $departementOffice->klausul_items()->attach($newKlausulsOffice);
    }
}
