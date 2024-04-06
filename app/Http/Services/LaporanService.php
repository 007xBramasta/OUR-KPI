<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanService
{
    public function getMonthlyReport($month, $year = null)
    {
        $laporanQuery = Laporan::query(); // Menggunakan query builder untuk membangun query
        if (auth()->user()->role === 'karyawan') {
            $laporanQuery->where('user_id', Auth::user()->id);
        } // Jika role user adalah karyawan, maka hanya menampilkan laporan yang dimiliki oleh user tersebut

        $laporanQuery->with('klausuls.klausul_items.penilaians'); // Eager loading untuk mengurangi jumlah query

        if (!is_null($year)) {
            $laporanQuery->whereYear('created_at', $year);
        }

        if (strlen($month) === 1) {
            $laporanQuery->whereMonth('created_at', $month);
        } elseif (strlen($month) > 1) {
            $months = explode(',', $month);
            $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months);
        }

        // Tambahkan logging sebelum mengembalikan hasil
        Log::info('Monthly report query executed', ['query' => $laporanQuery->toSql(), 'bindings' => $laporanQuery->getBindings()]);

        return $laporanQuery->get();
    }
}
