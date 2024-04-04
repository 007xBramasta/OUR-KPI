<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{

    public function get_penilaian(Request $request)
    {
        $laporanId = auth()->user()->laporan->first()->laporan_id;
        $data = \App\Models\Klausul::with('klausul_items.penilaians')
            ->whereHas('klausul_items.penilaians', function ($query) use ($laporanId) {
                $query->where('laporan_id', $laporanId);
            })
            ->get();

        $transformedData = $data->map(function ($klausul) {
            return [
                'klausul_id' => $klausul->id,
                'klausul_name' => $klausul->name,
                'klausul_items' => mapItems($klausul->klausul_items)
            ];
        })->values();

        return response()->json([
            'message' => 'Data penilaian berhasil diperoleh.',
            'data' => [
                'laporan' => Laporan::where('laporan_id', $laporanId)->first(),
                'penilaians' => $transformedData
            ]
        ]);
    }

    public function edit_penilaian()
    {
        $laporanId = auth()->user()->laporan->first()->laporan_id;
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

    public function update_penilaian(string $penilaianId, string $klausulItemId, Request $request)
    {

        $penilaian = Penilaian::where('id', '=', $penilaianId)
            ->where('klausul_item_id', '=', $klausulItemId)
            ->firstOrFail();

        if ($penilaian->laporan_id != auth()->user()) {
        }

        if ($request->has('aktual')) {
            if ($request->aktual != $penilaian->aktual) {
                $penilaian->aktual = $request->aktual;
            }
        }

        if ($request->has('keterangan')) {
            if ($request->keterangan != $penilaian->keterangan) {
                $penilaian->keterangan = $request->keterangan;
            }
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
