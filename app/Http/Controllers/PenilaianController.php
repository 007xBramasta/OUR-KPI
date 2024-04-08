<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\PenilaianService;
use App\Models\Penilaian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{

    public function __construct(protected PenilaianService $penilaianService)
    {
<<<<<<< HEAD
        $months = $request->input('months', [Carbon::now()->format('m')]); // Ambil bulan dari request, defaultnya bulan saat ini

        $laporanQuery = Laporan::query(); // Query builder untuk laporan

        if (auth()->user()->role !== 'admin') { // Jika user bukan admin, maka laporan yang diambil hanya laporan yang dimiliki oleh user tersebut
            $laporanQuery->where('user_id', '=', auth()->user()->id); // Filter laporan berdasarkan user id
        }

        $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months); // Filter laporan berdasarkan bulan
        $laporanQuery->with('klausuls.klausul_items.penilaians'); // Eager loading klausul, klausul item, dan penilaian
        $data = $laporanQuery->get();

        $transformedData = mapReportJson($data); // Transformasi data laporan

        return response()->json([
            'message' => 'Data penilaian berhasil diperoleh.',
            'data' => [
                'penilaians' => $transformedData
            ]
        ]);
=======
    }
    public function get_penilaian(Request $request): JsonResponse
    {
        try {
            $penilaianData = $this->penilaianService->getPenilaian($request);

            return response()->json([
                'message' => 'Data penilaian berhasil diperoleh.',
                'data' => $penilaianData
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error.'
            ], 500);
        }
>>>>>>> f82394073a677c8ac816f293b43bc2212fe0b154
    }

    public function update_penilaian(string $penilaianId, Request $request)
    {
<<<<<<< HEAD
        $penilaian = Penilaian::where('id', '=', $penilaianId) // Ambil data penilaian berdasarkan id
            ->where('klausul_item_id', '=', $klausulItemId) // Filter berdasarkan klausul item id
            ->firstOrFail();

        if ($request->user()->cannot('update', $penilaian)) { // Jika user tidak memiliki akses untuk update penilaian, maka kembalikan response 403
            return response([
                'error' => 'Anda tidak memiliki akses.'
            ], 403);
        }

        if ($penilaian->laporan_id != auth()->user()) {
        }

        if ($request->has('aktual')) {
            if ($request->aktual != $penilaian->aktual) {
                $penilaian->aktual = $request->aktual;
=======
        try {

            if ($request->user()->cannot('update', Penilaian::find($penilaianId))) {
                return response([
                    'error' => 'Anda tidak memiliki akses.'
                ], 403);
>>>>>>> f82394073a677c8ac816f293b43bc2212fe0b154
            }

            $penilaian =  $this->penilaianService->updatePenilaian($penilaianId, $request);

            return response()->json([
                'message' => 'Penilaian berhasil diperbaharui.',
                'data' => $penilaian
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error.'
            ], 500);
        }
    }

    public function get_rekomendasi(Request $request)
    {
<<<<<<< HEAD
        $laporan = Laporan::where('user_id', auth()->user()->id)->firstOrFail(); //
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
=======
        try {
>>>>>>> f82394073a677c8ac816f293b43bc2212fe0b154

            $rekomendasi = $this->penilaianService->getPenilaian($request);
            return response()->json([
                'data' => $rekomendasi
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error.'
            ], 500);
        }
    }

    public function update_rekomendasi($penilaianId, Request $request)
    {
        try {

            $rules = [
                'rekomendasi' => 'required|max:300'
            ];
            $validator =  Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->getMessageBag()
                ], 422);
            }

            if ($validator->passes()) {
                // ubah nilai rekomendasi dari penilaian terkait dengan nilai rekomendasi dari request
                $updatedData = $this->penilaianService->updatePenilaianRekomendasi($penilaianId, $request->rekomendasi);

                return response()->json([
                    'message' => 'Rekomendasi telah diupdate.',
                    'data' => $updatedData
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error'
            ]);
        }
    }

    public function update_setuju(string $penilaianId, string $klausulItemId, Request $request)
    {
        try {

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
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error'
            ],500);
        }
    }
}
