<?php

namespace Database\Seeders;

use App\Models\Klausul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlausulKlausulItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Klausul 1
            [
                'name' => 'Pembangunan dan Pemeliharaan Komitmen',
                'items' => [
                    [
                        'title' => "Terdapat kebijakan K3",
                    ],
                    [
                        'title' => "Kebijakan K3 dikomunikasikan",
                    ],
                    [
                        'title' => "Penetapan anggota penanganan keadaan darurat",
                    ],
                    [
                        'title' => "Seritifikasi pelatihan penanganan keadaan darurat",
                    ]
                ],
            ],
            // Klausul 2
            [
                'name' => 'Pembuatan dan Pendokumentasikan Rencana K3',
                'items' => [
                    [
                        'title' => 'Rencana kerja dan rencana khusus'
                    ],
                    [
                        'title' => 'Informasi K3 dikomunikasikan'
                    ],
                    [
                        'title' => 'Prosedur identifikasi bahaya'
                    ],
                    [
                        'title' => 'Identifikasi potensi bahaya, penilaian dan pengendalian resiko'
                    ]
                ]
            ],
            // Klausul 3
            [
                'name' => 'Pengendalian Perancangan',
                'items' => [
                    [
                        'title' => 'Bill of quantity (Planning, RAB, evaluasi)'
                    ],
                    [
                        'title' => 'Jumlah laporan perubahan'
                    ],
                    [
                        'title' => 'Prosedur perancangan dan modifikasi'
                    ]
                ]
            ],
            // Klausul 4
            [
                'name' => 'Pengendalian Dokumen',
                'items' => [
                    [
                        'title' => 'Dokumen edisi terbaru disimpan pada tempat yang ditentukan'
                    ],
                    [
                        'title' => 'Dokumen usang segera disingkirkan atau diberi tanda khusus'
                    ],
                    [
                        'title' => 'Prosedur pengendalian dokumen'
                    ]
                ]
            ],
            // Klausul 5
            [
                'name' => 'Pembelian dan Pengendalian Produk',
                'items' => [
                    [
                        'title' => 'Spesifikasi pembelian'
                    ],
                    [
                        'title' => 'Pemeriksaan kesesuaian barang dan jasa sesuai spesifikasi'
                    ],
                    [
                        'title' => 'Prosedur pengadaan barang dan jasa '
                    ]
                ]
            ],
            // Klausul 6
            [
                'name' => 'Keamanan Bekerja Berdasarkan SMK3 ',
                'items' => [
                    [
                        'title' => 'Terdapat prosedur pengendalian resiko'
                    ],
                    [
                        'title' => 'Setiap pekerjaan yang memiliki resiko tinggi menggunakan izin kerja'
                    ],
                    [
                        'title' => 'APD dalam kondisi layak dan sesuai standart yang berlaku'
                    ],
                    [
                        'title' => 'Evaluasi upaya pengendalian resiko secara berkala'
                    ],
                    [
                        'title' => 'Safety meeting'
                    ],
                    [
                        'title' => 'Safety talk'
                    ],
                    [
                        'title' => 'Toolbox meeting'
                    ],
                    [
                        'title' => 'Konsultasi pekerja'
                    ],
                    [
                        'title' => 'Kesesuaian kompetensi SPV'
                    ],
                    [
                        'title' => 'Jadwal rutin pemeliharaan, perawatan dan perbaikan'
                    ],
                    [
                        'title' => 'Jadwal rutin kalibrasi alat'
                    ],
                    [
                        'title' => 'Kesesuaian kompetensi teknisi'
                    ],
                    [
                        'title' => 'Sertifikat sarana dan peralatan produksi'
                    ],
                    [
                        'title' => 'Fasilitas keadaan darurat'
                    ],
                    [
                        'title' => 'Pemeriksaan alat tanggap darurat',
                        'children' => [
                            [
                                'title' => 'Inspeksi APAR'
                            ],
                            [
                                'title' => 'Inspeksi Hydrant'
                            ],
                            [
                                'title' => 'Inspeksi Fire Alarm System'
                            ],
                        ]
                    ],
                    [
                        'title' => 'Pelatihan keadaan tanggap darurat'
                    ],
                    [
                        'title' => 'Prosedur keadaan tanggap darurat'
                    ],
                    [
                        'title' => 'Tersedia fasilitas P3K'
                    ],
                    [
                        'title' => 'Inspeksi Peralatan P3K'
                    ],
                    [
                        'title' => 'Pelatihan P3K'
                    ],
                    [
                        'title' => 'Prosedur pengendalian resiko'
                    ]
                ],

            ],
            // Klausul 7
            [
                'name' => 'Standar Pemantauan',
                'items' => [
                    [
                        'title' => 'Inspeksi K3'
                    ],
                    [
                        'title' => 'Laporan Inspeksi K3'
                    ],
                    [
                        'title' => 'Laporan tindakan perbaikan'
                    ],
                    [
                        'title' => 'Pengukuran lingkungan kerja',
                        'children' => [
                            [
                                'title' => 'Faktor Fisika'
                            ],
                            [
                                'title' => 'Faktor Kimia'
                            ],
                            [
                                'title' => 'Faktor Biologi'
                            ],
                            [
                                'title' => 'Faktor Ergonomi'
                            ],
                            [
                                'title' => 'Faktor Psikologi'
                            ],
                        ]
                    ],
                    [
                        'title' => 'Medical check up'
                    ],
                    [
                        'title' => 'Program pelayanan kesehatan'
                    ],
                    [
                        'title' => 'Laporan pemeriksaan kesehatan tenaga kerja'
                    ]
                ]
            ],
            // Klausul 8
            [
                'name' => 'Pelaporan dan Perbaikan Kekurangan',
                'items' => [
                    [
                        'title' => 'Laporan unsafe action'
                    ],
                    [
                        'title' => 'Laporan unsafe condition'
                    ],
                    [
                        'title' => 'Laporan nearmiss'
                    ],
                    [
                        'title' => 'Laporan kecelakaan kerja'
                    ],
                    [
                        'title' => 'Tim investigasi terlatih dan berkompeten'
                    ],
                    [
                        'title' => 'Tindak lanjut kecelakaan'
                    ],
                    [
                        'title' => 'Prosedur pelaporan bahaya'
                    ],
                    [
                        'title' => 'Prosedur kecelakaan kerja'
                    ]
                ]
            ],
            // Klausul 9
            [
                'name' => 'Pengelolaan Material dan Perpindahan',
                'items' => [
                    [
                        'title' => 'Prosedur penyimpanan bahan'
                    ],
                    [
                        'title' => 'Prosedur barang yang rusak atau kadaluarsa'
                    ],
                    [
                        'title' => 'Prosedur pembuangan bahan'
                    ]
                ]
            ],
            // Klausul 10
            [
                'name' => 'Pengumpulan dan Penggunaan Data',
                'items' => [
                    [
                        'title' => 'Catatan K3'
                    ],
                    [
                        'title' => 'Prosedur pengendalian catatan K3'
                    ]
                ]
            ],
            // Klausul 11
            [
                'name' => 'Pemeriksaan SMK3',
                'items' => [
                    [
                        'title' => 'Melakukan audit internal'
                    ],
                    [
                        'title' => 'Laporan audit internal'
                    ],
                ]
            ],
            // Klausul 12
            [
                'name' => 'Pengembangan Keterampilan dan Kemampuan',
                'items' => [
                    [
                        'title' => 'Pelatihan K3'
                    ],
                    [
                        'title' => 'Pelatihan K3 dilakukan oleh orang dan badan yang berkompeten'
                    ],
                    [
                        'title' => 'Pelatihan lisensi dan kualifikasi tenaga kerja khusus'
                    ]
                ]
            ],
        ];

        foreach ($data as $klausulData) {
            $klausul = Klausul::create([
                'name' => $klausulData['name']
            ]);

            foreach ($klausulData['items'] as $item) {
                $klausulItem = $klausul->klausul_items()->create([
                    'title' => $item['title'],
                ]);

                if (isset($item['children'])) {
                    foreach ($item['children'] as $child) {
                        $klausulItem->children()->create([
                            'title' => $child['title'],
                            'klausul_id' => $klausul->id
                        ]);
                    }
                }
            }
        }
    }
}
