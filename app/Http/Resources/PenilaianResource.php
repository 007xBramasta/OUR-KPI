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
            'title' => $this->getKlausulItemTitle(),
            'target' => $this->target,
            'aktual' => $this->aktual,
            'keterangan' => $this->keterangan,
            'rekomendasi' => $this->when($request->user()->role === 'admin' || $request->path() === 'api/rekomendasi' , $this->rekomendasi) 
        ];
    }

    private function getKlausulItemTitle() :string{
        $itemTitle = $this->klausul_item->title;
        if($this->klausul_item->children !== []){
            foreach ($this->klausul_item->children as $index => $child) {
                $itemTitle = $itemTitle . $index+1 . '.' . $child->title;
            }
        }

        return $itemTitle;
    }
}
