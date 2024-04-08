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
    }

    public function update_penilaian(string $penilaianId, Request $request)
    {
        try {
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
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => 'Server error.'
            ], 500);
        }
    }

    public function get_rekomendasi(Request $request)
    {
        try {
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
            ], 500);
        }
    }
}
