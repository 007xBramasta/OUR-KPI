<?php

namespace App\Http\Services;

use App\Http\Resources\PenilaianResource;
use App\Models\KlausulItem;
use App\Models\Laporan;
use App\Models\Penilaian;
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
        return new PenilaianResource($penilaian);
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

    public function updatePenilaian(string $penilaianId, Request $request)
    {
        $penilaian = Penilaian::where('id', '=', $penilaianId)
            ->firstOrFail();

            if ($request->has('aktual')) {
                if ($request->aktual != $penilaian->aktual) {
                    $penilaian->aktual = $request->aktual;
                }
            }
    
            if ($request->has('keterangan')) {
                if ($request->keterangan != $penilaian->keterangan) {
                    $penilaian->keterangan = $request->keterangan;
                }
            }
        $penilaian->save();

        return new PenilaianResource($penilaian);
    }

    public function updatePenilaianRekomendasi(string $penilaianId, string $rekomendasi)
    {
        $penilaian = Penilaian::find($penilaianId);
        $penilaian->rekomendasi = $rekomendasi;
        $penilaian->save();   
        
        return new PenilaianResource($penilaian);
    }
}
