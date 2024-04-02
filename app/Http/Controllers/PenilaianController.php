<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $data = Penilaian::where('disetujui' , '=', '1')
            ->with('klausul')
            ->get();
        $transformedData = [];
        foreach ($data as $penilaian) {
            $transformedData[] = [
                'klausul' => $penilaian->klausul,
                'target' => $penilaian->penilaian_target,
                'aktual' => $penilaian->penilaian_aktual,
                'keterangan' => $penilaian->penilaian_keterangan,
            ];
        }
        return response()->json([
            'data' => $transformedData
        ]);
    }
}
