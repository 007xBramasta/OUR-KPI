<?php

namespace App\Http\Services;

use App\Http\Resources\PenilaianResource;
use App\Models\Klausul;
use App\Models\Laporan;
use App\Models\Penilaian;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenilaianService
{

    public function getPenilaian(Request $request)
    {
        try {
            $months = $request->input('months', [Carbon::now()->format('m')]);
            $laporanQuery = Laporan::query();

            if (auth()->user()->role !== 'admin') {
                $laporanQuery->where('user_id', '=', auth()->user()->id);
            }

            $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months);

            $queryResult = $laporanQuery->get();
            $transformedData = $this->transformData($queryResult);
            return $transformedData;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    private function transformData(Collection $data)
    {
        return $data->map(function ($report) {
            // Transform data laporan ke dalam bentuk yang diinginkan
            $klausuls = Klausul::all();
            return [
                'laporan_id' => $report->laporan_id,
                'klausuls' => $klausuls->map(function ($klausul) {
                    return $klausul->name;
                }),
                "klausulItems" => $klausuls->map(function ($k) use ($report) {
                    // return item dari setiap klausul
                    return $k->klausul_items->map(function ($item) use ($report) {

                        $penilaian = $item->penilaians()->where('laporan_id', '=', $report->laporan_id)->first();
                        if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                            return; // Skip item
                        }
                        $data = new PenilaianResource($penilaian);
                        return $data;
                    })->filter()->values();
                })->filter()->values()
            ];
        });
    }

    public function updatePenilaian(string $penilaianId, Request $request)
    {
        try {
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
            Log::info('Penilaian updated successfully.');

            return new PenilaianResource($penilaian);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function updatePenilaianRekomendasi(string $penilaianId, string $rekomendasi)
    {
        try {
            $penilaian = Penilaian::find($penilaianId);
            $penilaian->rekomendasi = $rekomendasi;
            $penilaian->save();
            Log::info('Rekomendasi penilaian updated successfully.');

            return new PenilaianResource($penilaian);
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
            throw $exception;
        }
    }
}
