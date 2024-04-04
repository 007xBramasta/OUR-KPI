<?php

namespace App\Http\Controllers;
use App\Http\Services\LaporanService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    protected $reportService;

    public function __construct(LaporanService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function showMonthlyReport(Request $request)
    {
        $month = $request->query('month');

        $monthlyReport = $this->reportService->getMonthlyReport($month);

        return response()->json([
            'data' => $monthlyReport
        ]);
    }
}
