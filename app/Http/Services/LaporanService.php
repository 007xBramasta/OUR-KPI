<?php

namespace App\Http\Services;

use App\Models\Laporan;
use App\Models\KlausulItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PenilaianResource;
use App\Models\Klausul;
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

    protected function transformData(Collection $reports)
    {
        return $reports->map(function ($report) {
            // Transform data laporan ke dalam bentuk yang diinginkan    

            // get klausuls
            $klausuls = Klausul::all();
            return [
                'laporan_id' => $report->laporan_id,
                'klausuls' => $klausuls->map(function ($klausul){
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
                        $data = new PenilaianResource($penilaian);
                        return $data;
                    });
                })
            ];
        });
    }
}
