<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\PenilaianService;
use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\Klausul;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class PenilaianController extends Controller
{

    public function __construct(protected PenilaianService $penilaianService)
    {
        
    }
    public function get_penilaian(Request $request)
    {
        $penilaianData = $this->penilaianService->getPenilaian($request);

        return response()->json([
            'message' => 'Data penilaian berhasil diperoleh.',
            'data' => $penilaianData
        ]);
    }

    public function update_penilaian(string $penilaianId,Request $request)
    {
        
        if ($request->user()->cannot('update', Penilaian::find($penilaianId))) {
            return response([
                'error' => 'Anda tidak memiliki akses.'
            ], 403);
        }

        $penilaian =  $this->penilaianService->updatePenilaian($penilaianId, $request);

        return response()->json([
            'message' => 'Penilaian berhasil diperbaharui.',
            'data' => $penilaian
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

    public function update_rekomendasi($penilaianId, Request $request)
    {
        // dapatkan data penilaian
        $penilaian = Penilaian::where('id', '=', $penilaianId)->first();

        // kembalikan response 403 jika user tidak memenuhi syarat update_rekomendasi dari policy
        if ($request->user()->cannot('update_rekomendasi', $penilaian)) {
            return response([
                'error' => 'Anda tidak memiliki akses.'
            ], 403);
        }

        $rules = [
            'rekomendasi' => 'required|max:300'
        ];
        $validator =  Validator::make($request->all(), $rules);

        // jika validasi request gagal kembalikan response 422
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()
            ], 422);
        }

        // ubah nilai rekomendasi dari penilaian terkait dengan nilai rekomendasi dari request
        if ($validator->passes()) {
            $penilaian->rekomendasi = $request->rekomendasi;
            $penilaian->save();

            return response()->json([
                'message' => 'Rekomendasi telah diupdate.',
                'data' => $penilaian
            ]);
        }
    }

    public function update_setuju(string $penilaianId, string $klausulItemId, Request $request)
    {
        // dapatkan data penilaian
        $penilaian = Penilaian::where('id', '=', $penilaianId)->first();

        $rules = [
            'setuju' => 'required|boolean'
        ];

        $validator =  Validator::make($request->only(['setuju']), $rules);
        // jika validasi request gagal kembalikan response 422
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()
            ], 422);
        }

        // ubah nilai rekomendasi dari penilaian terkait dengan nilai rekomendasi dari request
        if ($validator->passes()) {
            $penilaian->disetujui = $request->setuju;
            $penilaian->save();

            return response()->json([
                'message' => 'Penilaian telah disetujui.',
                'data' => $penilaian
            ]);
        }
    }
}
