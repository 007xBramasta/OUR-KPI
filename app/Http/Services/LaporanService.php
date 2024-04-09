<?php

namespace App\Http\Services;

use App\Models\Laporan;
use App\Models\KlausulItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PenilaianResource;
use Illuminate\Database\Eloquent\Collection;

class LaporanService
{
    public function getMonthlyReport($departementId, $month)
    {
        $user = Auth::user();

        try {
            $laporanQuery = Laporan::query()
                ->where('departements_id', $departementId)
                ->with('klausuls.klausul_items')
                ->whereMonth('created_at', $month);

            if ($user->role === 'karyawan') {
                $laporanQuery->where('user_id', $user->id);
            } // Jika role user adalah karyawan, maka hanya menampilkan laporan yang dibuat oleh user tersebut

            // Tambahkan logging sebelum mengembalikan hasil
            Log::info('Monthly report query executed', ['query' => $laporanQuery->toSql(), 'bindings' => $laporanQuery->getBindings()]);

            $transformedData = $this->transformData($laporanQuery->get());

            return $transformedData;
        } catch (\Exception $e) {
            Log::error('Error retrieving monthly report', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getDetailPenilaian(KlausulItem $item, $laporanId)
    {
        $penilaian = $item->penilaians()->where('laporan_id', $laporanId)->first();
        return new PenilaianResource($penilaian);
    }

    protected function transformData(Collection $reports)
    {
        return $reports->map(function ($report) {
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
                            if ($item->parent_id !== null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                                return; //
                            }
                            return [
                                'id' => $item->id,
                                'title' => $item->title,
                                'nilai' => $this->getDetailPenilaian($item, $report->laporan_id),
                                // Jika klausul item memiliki children, maka tampilkan children tersebut
                                'children' => $item->children != [] ? $item->children->map(function ($child) use ($report) {
                                    return [
                                        'id' => $child->id,
                                        'title' => $child->title,
                                        'nilai' => $this->getDetailPenilaian($child, $report->laporan_id),
                                    ];
                                }) : null
                            ];
                        })->filter()->values(),
                    ];
                }),
            ];
        });
    }
}
