<?php

namespace App\Http\Services;

use App\Models\KlausulItem;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianService
{

    public function getPenilaian(Request $request)
    {
        $months = $request->input('months', [Carbon::now()->format('m')]);
        $laporanQuery = Laporan::query();

        if (auth()->user()->role !== 'admin') {
            $laporanQuery->where('user_id', '=', auth()->user()->id);
        }

        $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months);
        $laporanQuery->with('klausuls.klausul_items');

        $queryResult = $laporanQuery->get();
        $transformedData = $this->transformData($queryResult);
        return $transformedData;
    }

    private function getDetailPenilaian(KlausulItem $item, $laporanId){

        $penilaian = $item->penilaians()->where('laporan_id', $laporanId)->first();
        return [
            'penilaian_id' => $penilaian->id,
            'aktual' => $penilaian->aktual,
            'keterangan' => $penilaian->keterangan
        ];
    }

    private function transformData(Collection $data){
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
                                }) : null // Jika tidak memiliki children, maka tampilkan null
                            ];
                        })->filter()->values() // Filter item yang bernilai null
                    ];
                })
            ];
        });
    }
}
