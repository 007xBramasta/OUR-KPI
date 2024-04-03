<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public function klausul_item(): BelongsTo
    {
        return $this->belongsTo(KlausulItem::class, 'klausul_item_id', 'id');
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id', 'id');
    }

    public function klausul()
    {
        return $this->hasOneThrough(Klausul::class, KlausulItem::class, 'id', 'id', 'klausul_item_id', 'klausul_id');
    }
}
