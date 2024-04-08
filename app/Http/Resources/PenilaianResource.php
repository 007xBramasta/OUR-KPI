<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenilaianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'penilaian_id' => $this->id,
            'aktual' => $this->aktual,
            'keterangan' => $this->keterangan,
            'disetujui' => $this->disetujui,
            'rekomendasi' => $this->when($request->user()->role === 'admin' || $request->path() === 'api/rekomendasi' , $this->rekomendasi) 
        ];
    }
}
