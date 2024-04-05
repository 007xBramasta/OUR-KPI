<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanService
{
    public function getMonthlyReport($month)
    {
        DB::enableQueryLog(); // Enable query log

        if (strlen($month) === 1) {
    
            $query = DB::table('laporan')
                ->whereRaw("SUBSTRING(created_at, 6, 2) = ?", [$month]);

            Log::info($query->toSql(), $query->getBindings()); 

            return $query->get();
        }

        if (strlen($month) > 1) {
            
            $months = explode(',', $month);

            $query = DB::table('laporan')
                ->where(function ($query) use ($months) {
                    foreach ($months as $month) {
                        $query->orWhereRaw("SUBSTRING(created_at, 6, 2) = ?", [$month]);
                    }
                });

            Log::info($query->toSql(), $query->getBindings()); // Log the SQL query

            return $query->get();
        }
    }
}