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
                'klausul_name' => 'Pembangunan dan Pemeliharaan Komitmen',
                'item' => json_encode([
                    'Terdapat kebijakan K3',
                    'Kebijakan K3 dikomunikasikan'
                ])
            ],
            [
                'klausul_name' => 'Pembuatan dan Pendokumentasikan Rencana K3',
                'item' => json_encode([
                    'Rencana kerja dan rencana khusus',
                    'Informasi K3 dikomunikasikan'
                ])
            ],
            [
                'klausul_name' => 'Pengendalian Perancangan',
                'item' => json_encode([
                    'Bill of quantity (Planning, RAB, evaluasi)',
                    'Jumlah laporan perubahan'
                ])
            ],
            [
                'klausul_name' => 'Pengendalian Dokumen',
                'item' => json_encode([
                    'Dokumen edisi terbaru disimpan pada tempat yang ditentukan',
                    'Dokumen usang segera disingkirkan atau diberi tanda khusus'
                ])
            ],
            [
                'klausul_name' => 'Pembelian dan Pengendalian Produk',
                'item' => json_encode([
                    'Spesifikasi pembelian',
                    'Pemeriksaan kesesuaian barang dan jasa sesuai spesifikasi'
                ])
            ],
            [
                'klausul_name' => 'Keamanan Bekerja Berdasarkan SMK3',
                'item' => json_encode([
                    'Terdapat prosedur pengendalian resiko',
                    'Setiap pekerjaan yang memiliki resiko tinggi menggunakan izin kerja',
                    'APD dalam kondisi layak dan sesuai standart yang berlaku',
                    'Evaluasi upaya pengendalian resiko secara berkala',
                    'Safety meeting',
                    'Safety talk',
                    'Toolbox meeting',
                    'Konsultasi pekerja',
                    'Kesesuaian kompetensi SPV',
                    'Jadwal rutin pemeliharaan, perawatan dan perbaikan',
                    'Jadwal rutin kalibrasi alat',
                    'Kesesuaian kompetensi teknisi',
                    'Sertifikat sarana dan peralatan produksi',
                    'Fasilitas keadaan darurat',
                    'Pemeriksaan alat tanggap darurat' => [
                        'Inspeksi APAR', 
                        'Inspeksi Hydrant', 
                        'Inspeksi Fire Alarm System'
                    ],
                    'Pelatihan keadaan tanggap darurat',
                    'Prosedur keadaan tanggap darurat',
                    'Tersedia fasilitas P3K',
                    'Inspeksi Peralatan P3K',
                    'Pelatihan P3K'
                ])
            ],
            [
                'klausul_name' => 'Standar Pemantauan',
                'item' => json_encode([
                    'Inspeksi K3',
                    'Laporan inspeksi K3',
                    'Laporan tindakan perbaikan',
                    'Pengukuran lingkungan kerja' => [
                        'Faktor Fisika', 
                        'Faktor Kimia', 
                        'Faktor Biologi', 
                        'Faktor Ergonomi', 
                        'Faktor Psikologi',
                    ],   
                    'Medical check up',
                    'Program pelayanan kesehatan'
                ])
            ],
            [
                'klausul_name' => 'Pelaporan dan Perbaikan Kekurangan',
                'item' => json_encode([
                    'Laporan unsafe action',
                    'Laporan unsafe condition',
                    'Laporan nearmiss',
                    'Laporan kecelakaan kerja',
                    'Tim investigasi terlatih dan berkompeten',
                    'Tindak lanjut kecelakaan'
                ])
            ],
            [
                'klausul_name' => 'Pengelolaan Material dan Perpindahan',
                'item' => json_encode([
                    'Prosedur penyimpanan bahan',
                    'Prosedur barang yang rusak atau kadaluarsa'
                ])
            ],
            [
                'klausul_name' => 'Pengumpulan dan Penggunaan Data',
                'item' => json_encode([
                    'Catatan K3'
                ])
            ],
            [
                'klausul_name' => 'Pemeriksaan SMK3',
                'item' => json_encode([
                    'Melakukan audit internal',
                    'Laporan audit internal'
                ])
            ],
            [
                'klausul_name' => 'Pengembangan Keterampilan dan Kemampuan',
                'item' => json_encode([
                    'Pelatihan K3',
                    'Pelatihan K3 dilakukan oleh orang dan badan yang berkompeten'
                ])
            ],
        ];

        foreach ($klausuls as $klausulData) {
            Klausul::create([
                'klausul_name' => $klausulData['klausul_name'],
                'item' => $klausulData['item']
            ]);
        }
    }
}
