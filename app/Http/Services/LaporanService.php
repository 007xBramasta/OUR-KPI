<?php

namespace App\Http\Services;

use App\Models\Klausul;
use App\Models\Laporan;
use App\Models\KlausulItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LaporanResource;
use Illuminate\Database\Eloquent\Collection;

class LaporanService
{
    public function getMonthlyReport($departementId, $month)
    {
        $user = Auth::user();

        try {
            $laporanQuery = Laporan::query()
                ->where('departements_id', $departementId)
                ->whereMonth('created_at', $month);

            if ($user->role === 'karyawan') {
                Log::info('User role is karyawan, filtering by user id', ['userId' => $user->id]);
                $laporanQuery->where('user_id', $user->id);
            }

            Log::info('Monthly report query executed', ['query' => $laporanQuery->toSql(), 'bindings' => $laporanQuery->getBindings()]);

            $laporans = $laporanQuery->get();
            Log::info('Fetched monthly report successfully', ['total' => $laporans->count()]);

            $transformedData = $this->transformData($laporans);

            Log::info('Transformed report data', ['data' => $transformedData]);

            return $transformedData;
        } catch (\Exception $e) {
            Log::error('Error retrieving monthly report', ['error' => $e->getMessage(), 'trace' => $e->getTrace()]);
            throw $e;
        }
    }

    protected function transformData(Collection $reports)
    {
        return $reports->map(function ($report) {
            // Transform data laporan ke dalam bentuk yang diinginkan    

            // get klausuls
            $klausuls = Klausul::all();
            return [
                'laporan_id' => $report->laporan_id,
                'user' => $report->user->email,
                'klausuls' => $klausuls->map(function ($klausul) {
                    // map string of klausul name
                    return $klausul->name;
                }),
                "klausulItems" => $klausuls->map(function ($k) use ($report) {
                    // return item dari setiap klausul
                    return $k->klausul_items->map(function ($item) use ($report) {

                        $penilaian = $item->penilaians()->where('laporan_id', '=', $report->laporan_id)->first();
                        if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                            return; // Skip item
                        }
                        $data = new LaporanResource($penilaian);
                        return $data;
                    })->filter()->values();
                })->filter()->values()
            ];
        });
    }


    private function generateCacheKey($userId, $month)
    {
        if ($month) {
            return $userId . '-' . $month . '-' . 'Laporan';
        } else {
            return $userId . '-' . 'Laporan';
        }
    }
}
