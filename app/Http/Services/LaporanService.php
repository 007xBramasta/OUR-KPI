<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    public function getMonthlyReport($month)
    {
        if (strlen($month) === 1) {
            return DB::table('laporan')
                ->whereRaw("SUBSTRING(created_at, 6, 2) = ?", [$month])
                ->get();
        }

        if (strlen($month) > 1) {
            // Mendapatkan array bulan dari input yang diberikan
            $months = explode(',', $month);

            // Menggunakan OR untuk mencari laporan dengan bulan yang sesuai dengan array bulan yang diberikan
            return DB::table('laporan')
                ->where(function ($query) use ($months) {
                    foreach ($months as $month) {
                        $query->orWhereRaw("SUBSTRING(created_at, 6, 2) = ?", [$month]);
                    }
                })
                ->get();
        }
    }
}
