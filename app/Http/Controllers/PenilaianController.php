<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\Klausul;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{

    public function get_penilaian(Request $request)
    {
        $months = $request->input('months', [Carbon::now()->format('m')]);
        $laporanQuery = Laporan::query();

        if (auth()->user()->role !== 'admin') {
            $laporanQuery->where('user_id', '=', auth()->user()->id);
        }

        $laporanQuery->whereIn(DB::raw('MONTH(created_at)'), $months);
        $laporanQuery->with('klausuls.klausul_items.penilaians');
        $data = $laporanQuery->get();

        $transformedData = $data->map(function ($report) {
            // Transform data laporan ke dalam bentuk yang diinginkan
            return [
                'laporan_id' => $report->laporan_id,
                'klausuls' => $report->klausuls->map(function ($klausul) {
                    // Transform data klausul ke dalam bentuk yang diinginkan
                    return [
                        'id' => $klausul->id,
                        'name' => $klausul->name,
                        'klausul_items' => $klausul->klausul_items->map(function ($item) {
                            // Transform data klausul item ke dalam bentuk yang diinginkan
                            if ($item->parent_id != null) { // Jika klausul item adalah child, maka tidak perlu ditampilkan
                                return; // Skip item
                            }
                            return [
                                'id' => $item->id,
                                'title' => $item->title,
                                'nilai' => [
                                    'penilaian_id' => $item->penilaians->first()->id,
                                    'target' => $item->penilaians->first()->target,
                                    'aktual' => $item->penilaians->first()->aktual,
                                    'keterangan' => $item->penilaians->first()->keterangan,
                                    'rekomendasi' => $item->penilaians->first()->rekomendasi,
                                ],
                                // Jika klausul item memiliki children, maka tampilkan children tersebut
                                'children' => $item->children != [] ? $item->children->map(function ($child) {
                                    return [
                                        'id' => $child->id,
                                        'title' => $child->title,
                                        'nilai' => [
                                            'penilaian_id' => $child->penilaians->first()->id,
                                            'target' => $child->penilaians->first()->target,
                                            'aktual' => $child->penilaians->first()->aktual,
                                            'keterangan' => $child->penilaians->first()->keterangan,
                                            'rekomendasi' => $child->penilaians->first()->rekomendasi,
                                        ],
                                    ];
                                }) : null // Jika tidak memiliki children, maka tampilkan null
                            ];
                        })->filter()->values() // Filter item yang bernilai null
                    ];
                })
            ];
        });

        return response()->json([
            'message' => 'Data penilaian berhasil diperoleh.',
            'data' => [
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

        if ($request->user()->cannot('update', $penilaian)) {
            return response([
                'error' => 'Anda tidak memiliki akses.'
            ], 403);
        }

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
