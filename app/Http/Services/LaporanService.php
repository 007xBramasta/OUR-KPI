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
use App\Models\Departement;
use Illuminate\Database\Eloquent\Collection;

class LaporanService
{
    public function getMonthlyReport($departementId, $month)
    {
        $user = Auth::user();
        $totalKlausulItems =  Departement::find($departementId)->klausul_items->count();

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

            $transformedData = $this->transformData($laporans, $totalKlausulItems);
            Log::info('Transformed report data', ['data' => $transformedData]);

            return $transformedData;
        } catch (\Exception $e) {
            Log::error('Error retrieving monthly report', ['error' => $e->getMessage(), 'trace' => $e->getTrace()]);
            throw $e;
        }
    }

    protected function transformData(Collection $reports, $totalKlausulItems)
    {
        return $reports->map(function ($report) use ($totalKlausulItems) {
            // Transform data laporan ke dalam bentuk yang diinginkan    

            // get klausuls
            $klausuls = Klausul::all();
            $totalAktual = 0;

            $klausulItems = $klausuls->map(function ($k) use ($report, &$totalAktual) {
                // return item dari setiap klausul
                return $k->klausul_items->map(function ($item) use ($report, &$totalAktual) {
                    if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                        return; // Skip item
                    }
                    $penilaian = $item->penilaians()->where('laporan_id', '=', $report->laporan_id)->first();
                    if($penilaian === null){
                        return;
                    }
                    if ($penilaian) {
                        $totalAktual += $penilaian->aktual; 
                    }

                    $data = new LaporanResource($penilaian);
                    $data['user'] = $report->user->email;
                    return $data;
                })->filter()->values(); 
            })->filter()->values();

            $persentase =  ($totalAktual / $totalKlausulItems) * 100;

            return [
                'laporan_id' => $report->laporan_id,
                'user' => $report->user->email,
                'klausuls' => $klausuls->map(function ($klausul) {
                    return $klausul->name;
                }),
                'klausulItems' => $klausulItems,
                'total' => "$persentase %",
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
