<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        // user masih sementara
        $laporan = Laporan::where('user_id', User::first()->id)->firstOrFail();
        $data = $laporan->penilaian()->where('disetujui' , '=', '1')
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
            'data' => [
                "laporan" => $laporan,
                "penilaians" =>$transformedData
            ]
        ]);
    }
}
