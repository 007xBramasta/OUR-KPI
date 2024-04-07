<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanService
{
    public function getMonthlyReport($departementId, $month)
    {
        $user = Auth::user();

        $laporanQuery = Laporan::query()
            ->where('departements_id', $departementId)
            ->with('klausuls.klausul_items.penilaians')
            ->whereMonth('created_at', $month);

        if ($user->role === 'karyawan') {
            $laporanQuery->where('user_id', $user->id);
        } // Jika role user adalah karyawan, maka hanya menampilkan laporan yang dibuat oleh user tersebut

        // Tambahkan logging sebelum mengembalikan hasil
        Log::info('Monthly report query executed', ['query' => $laporanQuery->toSql(), 'bindings' => $laporanQuery->getBindings()]);

        $transformedData = $this->transformData($laporanQuery->get());

        return $transformedData;
    }

    protected function transformData($reports)
    {
        return $reports->map(function ($report) {
            return [
                'laporan_id' => $report->laporan_id,
                'klausuls' => $report->klausuls->map(function ($klausul) {
                    return [
                        'id' => $klausul->id,
                        'name' => $klausul->name,
                        'klausul_items' => $klausul->klausul_items->map(function ($item) {
                            if ($item->parent_id !== null) {
                                return null;
                            }
                            return [
                                'id' => $item->id,
                                'title' => $item->title,
                                'nilai' => [
                                    'target' => $item->penilaians->first()->target,
                                    'aktual' => $item->penilaians->first()->aktual,
                                    'keterangan' => $item->penilaians->first()->keterangan,
                                    'rekomendasi' => $item->penilaians->first()->rekomendasi,
                                ],
                                'children' => $item->children->map(function ($child) {
                                    return [
                                        'id' => $child->id,
                                        'title' => $child->title,
                                        'nilai' => [
                                            'target' => $child->penilaians->first()->target,
                                            'aktual' => $child->penilaians->first()->aktual,
                                            'keterangan' => $child->penilaians->first()->keterangan,
                                            'rekomendasi' => $child->penilaians->first()->rekomendasi,
                                        ],
                                    ];
                                }),
                            ];
                        })->filter()->values(),
                    ];
                }),
            ];
        });
    }
    
}
