<?php

namespace App\Http\Controllers;

use App\Http\Services\LaporanService;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

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

        $transformedData = $monthlyReport->map(function ($report) {
            // Transform data laporan ke dalam bentuk yang diinginkan
            return [
                'laporan_id' => $report->laporan_id,
                'klausuls' => $report->klausuls->map( function ($klausul){
                    // Transform data klausul ke dalam bentuk yang diinginkan
                    return [
                        'id' => $klausul->id,
                        'name' => $klausul->name,
                        'klausul_items' => $klausul->klausul_items->map(function ($item){
                            // Transform data klausul item ke dalam bentuk yang diinginkan
                            if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                                return; // Skip item
                            }
                            return [
                                'id' => $item->id,
                                'title' => $item->title,
                                'nilai' => [
                                    'target' => $item->penilaians->first()->target,
                                    'aktual' => $item->penilaians->first()->aktual,
                                    'keterangan' => $item->penilaians->first()->keterangan,
                                    'rekomendasi' => $item->penilaians->first()->rekomendasi,
                                ],
                                // Jika klausul item memiliki children, maka tampilkan children tersebut
                                'children' => $item->children != [] ? $item->children->map(function ($child){
                                    return [
                                        'id' => $child->id,
                                        'title' => $child->title,
                                        'nilai' => [
                                            'target' => $child->penilaians->first()->target,
                                            'aktual' => $child->penilaians->first()->aktual,
                                            'keterangan' => $child->penilaians->first()->keterangan,
                                            'rekomendasi' => $child->penilaians->first()->rekomendasi,
                                        ],  
                                    ];
                                }): null // Jika tidak memiliki children, maka tampilkan null
                            ];
                        })->filter()->values() // Filter item yang bernilai null
                    ];
                }) 
            ];
        });

        return response()->json([
            'data' => $transformedData,
            'total' => $monthlyReport->count()
        ]);
    }
}
