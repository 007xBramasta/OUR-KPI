<?php


function mapReportJson($data)
{
    return $data->map(function ($report) {
        // Transform data laporan ke dalam bentuk yang diinginkan
        return [
            'laporan_id' => $report->laporan_id,
            'klausuls' => $report->klausuls->map(function ($klausul) use ($report) {
                // Transform data klausul ke dalam bentuk yang diinginkan
                return [
                    'id' => $klausul->id,
                    'name' => $klausul->name,
                    'klausul_items' => $klausul->klausul_items->map(function ($item) use ($report) {
                        // Transform data klausul item ke dalam bentuk yang diinginkan
                        if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                            return; // Skip item
                        }
                        $nilai = $report->penilaians()->where('klausul_item_id', $item->id)->first();
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'nilai' => [
                                'penilaian_id' => $nilai->id,
                                'target' => $nilai->target,
                                'aktual' => $nilai->aktual,
                                'keterangan' => $nilai->keterangan,
                                'rekomendasi' => $nilai->rekomendasi,
                                'disetujui' => $nilai->disetujui
                            ],
                            // Jika klausul item memiliki children, maka tampilkan children tersebut
                            'children' => $item->children != [] ? $item->children->map(function ($child) use ($report) {
                                $nilai = $report->penilaians()->where('klausul_item_id', $child->id)->first();

                                return [
                                    'id' => $child->id,
                                    'title' => $child->title,
                                    'nilai' => [
                                        'penilaian_id' => $nilai->id,
                                        'target' => $nilai->target,
                                        'aktual' => $nilai->aktual,
                                        'keterangan' => $nilai->keterangan,
                                        'rekomendasi' => $nilai->rekomendasi,
                                        'disetujui' => $nilai->disetujui
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
