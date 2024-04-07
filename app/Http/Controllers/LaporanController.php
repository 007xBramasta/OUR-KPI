<?php

namespace App\Http\Controllers;

use App\Http\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    protected $reportService;

    public function __construct(LaporanService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function showMonthlyReport($departementId, Request $request)
    {
        $month = $request->query('month');

        // Validasi parameter month
        if (!is_numeric($month) || $month < 1 || $month > 12) {
            return response()->json(['error' => 'Invalid month parameter'], 400);
        }

        try {
            $cacheKey = $this->generateCacheKey(Auth::user()->id, $month);

            if (Cache::has($cacheKey)) {
                $cachedData = Cache::get($cacheKey);
                Log::info('Returning data from cache', ['key' => $cacheKey, 'data' => $cachedData]);
                return response()->json($cachedData);
            }

            $transformedData = $this->reportService->getMonthlyReport($departementId, $month);
            
            Cache::put($cacheKey, [
                'data' => $transformedData,
                'total' => $transformedData->count()
            ], now()->addHour());
            Log::info('Caching laporan data', ['key' => $cacheKey, 'data' => $transformedData]);

            return response()->json([
                'data' => $transformedData,
                'total' => count($transformedData)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch monthly report', ['error' => $e->getMessage()]);
            // Tambahkan penanganan error
            return response()->json(['error' => 'Failed to fetch monthly report'], 500);
        }
    }

    private function generateCacheKey($userId, $month)
    {
        if ($month) {
            return $userId . '-' . $month . '-' .'Laporan';
        } else {
            return $userId . '-' . 'Laporan';
        }
    }
}
