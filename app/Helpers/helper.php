<?php


function mapReportJson( $data)
{
    return $data->map(function ($report) {
        // Transform data laporan ke dalam bentuk yang diinginkan
        return [
            'laporan_id' => $report->laporan_id,
            'klausuls' => $report->klausuls->map(function ($klausul) {
                // Transform data klausul ke dalam bentuk yang diinginkan
                return [
                    'id' => $klausul->id,
                    'name' => $klausul->name,
                    'klausul_items' => $klausul->klausul_items->map(function ($item) {
                        // Transform data klausul item ke dalam bentuk yang diinginkan
                        if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                            return; // Skip item
                        }
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'nilai' => [
                                'penilaian_id' => $item->penilaians->first()->id,
                                'target' => $item->penilaians->first()->target,
                                'aktual' => $item->penilaians->first()->aktual,
                                'keterangan' => $item->penilaians->first()->keterangan,
                                'rekomendasi' => $item->penilaians->first()->rekomendasi,
                                'disetujui' => $item->penilaians->first()->disetujui
                            ],
                            // Jika klausul item memiliki children, maka tampilkan children tersebut
                            'children' => $item->children != [] ? $item->children->map(function ($child) {
                                return [
                                    'id' => $child->id,
                                    'title' => $child->title,
                                    'nilai' => [
                                        'penilaian_id' => $child->penilaians->first()->id,
                                        'target' => $child->penilaians->first()->target,
                                        'aktual' => $child->penilaians->first()->aktual,
                                        'keterangan' => $child->penilaians->first()->keterangan,
                                        'rekomendasi' => $child->penilaians->first()->rekomendasi,
                                        'disetujui' => $child->penilaians->first()->disetujui
                                    ],
                                ];
                            }) : null // Jika tidak memiliki children, maka tampilkan null
                        ];
                    })->filter()->values() // Filter item yang bernilai null
                ];
            })
        ];
    });
}

