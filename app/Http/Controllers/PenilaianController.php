<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Klausul;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{

    public function get_penilaian($laporanId, Request $request)
    {

        $disetujui = $request->query('setuju');
        $penilaians = Penilaian::where('laporan_id', '=', $laporanId)->with('klausul.klausul_items.penilaians')->get();
        $transformedData = $penilaians->groupBy(function ($item) {
            return $item->klausul->name;
        })->map(function ($group) {
            return [
                'klausul_id' => $group->first()->klausul->id,
                'klausul_name' => $group->first()->klausul->name,
                'klausul_items' => mapItems($group->first()->klausul->klausul_items)
            ];
        })->values();

        return response()->json([
            'data' => $transformedData
        ]);
    }

    public function update_penilaian(string $penilaianId, string $klausulId, Request $request)
    {
        $laporan = Laporan::where('user_id', '=', auth()->user()->id)->first();
        $penilaian = Penilaian::where('penilaian_id', '=', $penilaianId)
            ->where('klausul_id', '=', $klausulId)
            ->where('klausul_id', '=', $klausulId)
            ->where('laporan_id', '=', $laporan->laporan_id)
            ->firstOrFail();

        if ($request->has('penilaian_aktual')) {
            $penilaian->penilaian_aktual = $request->penilaian_aktual;
        }

        if ($request->has('penilaian_keterangan')) {
            $penilaian->penilaian_keterangan = $request->penilaian_penilaian_keterangan;
        }

        $penilaian->save();

        return response()->json([
            'message' => 'Penilaian berhasil diperbaharui.'
        ]);
    }

    public function get_rekomendasi()
    {
        $laporan = Laporan::where('user_id', auth()->user()->id)->firstOrFail();
        $data = $laporan->penilaian()->where('disetujui', '=', '1')
            ->with('klausul')
            ->get();
        $transformedData = [];
        foreach ($data as $penilaian) {
            $transformedData[] = [
                'klausul' => $penilaian->klausul,
                'target' => $penilaian->penilaian_target,
                'aktual' => $penilaian->penilaian_aktual,
                'keterangan' => $penilaian->penilaian_keterangan,
                'rekomendasi' => $penilaian->rekomendasi
            ];
        }

        return response()->json([
            'data' => [
                "laporan" => $laporan,
                "penilaians" => $transformedData
            ]
        ]);
    }
}
