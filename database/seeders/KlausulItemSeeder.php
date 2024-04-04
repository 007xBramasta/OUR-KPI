<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KlausulItemSeeder extends Seeder
{
    public function run()
    {
        $klausulsName = DB::table('klausuls')->pluck('name')->toArray();
        $klausulsId = DB::table('klausuls')->pluck('id')->toArray(); 
        $klausulsItemId = DB::table('klausul_items')->pluck('id')->toArray();

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[0],
            'title' => 'Terdapat kebijakan K3'
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[0], 
            'title' => 'Kebijakan K3 dikomunikasikan'    
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[1], 
            'title' => 'Rencana kerja dan rencana khusus'    
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[1], 
            'title' => 'Informasi K3 dikomunikasikan'    
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[2], 
            'title' => 'Bill of quantity (Planning, RAB, evaluasi)'    
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[2], 
            'title' => 'Jumlah laporan perubahan'    
        ]);    
        
        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[3], 
            'title' => 'Dokumen edisi terbaru disimpan pada tempat yang ditentukan'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[3], 
            'title' => 'Dokumen usang segera disingkirkan atau diberi tanda khusus'    
        ]);  
        
        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[4], 
            'title' => 'Spesifikasi pembelian'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[4], 
            'title' => 'Pemeriksaan kesesuaian barang dan jasa sesuai spesifikasi'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Terdapat prosedur pengendalian resiko'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Setiap pekerjaan yang memiliki resiko tinggi menggunakan izin kerja'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'APD dalam kondisi layak dan sesuai standart yang berlaku'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Evaluasi upaya pengendalian resiko secara berkala'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Safety meeting'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Safety talk'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Toolbox meeting'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Konsultasi pekerja'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Kesesuaian kompetensi SPV'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Jadwal rutin pemeliharaan, perawatan dan perbaikan'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Jadwal rutin kalibrasi alat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Kesesuaian kompetensi teknisi'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Sertifikat sarana dan peralatan produksi'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Fasilitas keadaan darurat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Pemeriksaan alat tanggap darurat:'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'parent_id' => $klausulsItemId[5],
            'title' => 'Inspeksi APAR'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'parent_id' => $klausulsItemId[5],
            'title' => 'Inspeksi Hydrant'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'parent_id' => $klausulsItemId[5],
            'title' => 'Inspeksi Fire Alarm System'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Pelatihan keadaan tanggap darurat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Prosedur keadaan tanggap darurat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Tersedia fasilitas P3K'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Prosedur keadaan tanggap darurat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Inspeksi Peralatan P3K'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Pelatihan P3K'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[5], 
            'title' => 'Prosedur keadaan tanggap darurat'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'title' => 'Inspeksi K3'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'title' => 'Laporan inspeksi K3'    
        ]);  
        
        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'title' => 'Pengukuran lingkungan kerja :'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Faktor Fisika'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Faktor Kimia'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Faktor Biologi'    
        ]);

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Faktor Ergonomi'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Faktor Psikologi'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Medical check up'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[6], 
            'parent_id' => $klausulsItemId[6],
            'title' => 'Program pelayanan kesehatan'    
        ]); 
        
        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Laporan unsafe action'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Laporan unsafe condition'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Laporan nearmiss'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Laporan unsafe action'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Laporan kecelakaan kerja'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Tim investigasi terlatih dan berkompeten'    
        ]); 
        
        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[7], 
            'title' => 'Tindak lanjut kecelakaan'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[8], 
            'title' => 'Prosedur penyimpanan bahan'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[8], 
            'title' => 'Prosedur barang yang rusak atau kadaluarsa'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[9], 
            'title' => 'Catatan K3'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[10], 
            'title' => 'Melakukan audit internal'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[10], 
            'title' => 'Laporan audit internal'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[11], 
            'title' => 'Pelatihan K3'    
        ]);  

        DB::table('klausul_items')->insert([
            'id' => Str::uuid(),
            'klausul_id' => $klausulsId[11], 
            'title' => 'Pelatihan K3 dilakukan oleh orang dan badan yang berkompeten'    
        ]);  
    }
}
