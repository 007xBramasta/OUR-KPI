<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Laporan;

class LaporanService
{
    public function getMonthlyReport($month, $year = null)
    {
        $laporanQuery = Laporan::query();

        if (!is_null($year)) {
            $laporanQuery->whereYear('created_at', $year);
        }

        if (strlen($month) === 1) {
            $laporanQuery->whereMonth('created_at', $month);
        } elseif (strlen($month) > 1) {
            $months = explode(',', $month);
            $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months);
        }

        return $laporanQuery->get();
    }
}
