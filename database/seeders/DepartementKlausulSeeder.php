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
            'Bill of quantity (Planning, RAB, evaluasi)',
            'Jumlah laporan perubahan',
            'Prosedur perancangan dan modifikasi',
            'Pelatihan K3',
            'Pelatihan K3 dilakukan oleh orang dan badan yang berkompeten',
        ];

        // Menghubungkan klausul yang pasti ada di semua departement
        $departements = Departement::whereNotIn('departements_name', ['Maintenance', 'Office'])->get();
        $klausuls = KlausulItem::whereNotIn('title', $titles)->get();

        $departements->each(function ($departement) use ($klausuls) {
            $existingKlausuls = $departement->klausul_items->pluck('id')->toArray();
            $newKlausuls = $klausuls->whereNotIn('id', $existingKlausuls);
            $departement->klausul_items()->attach($newKlausuls);
        });

        // KlausulItem Office
        $departementOffice = Departement::where('departements_name', 'Office')->first();
        $klausulItems = KlausulItem::all();
        $departementOffice->klausul_items()->attach($klausulItems);

        // Menghubungkan klausul yang hanya  ada di departement Office
        $departementMaintenance = Departement::where('departements_name', 'Maintenance')->first();
        $klausulItems = KlausulItem::whereNotIn('title', [
            'Rencana kerja dan rencana khusus',
            'Informasi K3 dikomunikasikan',
            'Bill of quantity (Planning, RAB, evaluasi)',
            'Jumlah laporan perubahan',
            'Prosedur perancangan dan modifikasi',
            'Melakukan audit internal',
            'Laporan audit internal',
            'Pelatihan K3'
        ])->get();
        $departementMaintenance->klausul_items()->attach($klausulItems);
    }
}
