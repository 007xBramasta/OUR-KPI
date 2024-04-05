<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class KlausulItem extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    public $timestamps = false;
    
    public function children(): HasMany
    {
        return $this->hasMany(KlausulItem::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(KlausulItem::class, 'parent_id', 'id');
    }

    public function klausul(): BelongsTo
    {
        return $this->belongsTo(Klausul::class, 'klausul_id', 'id');
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'klausul_item_id', 'id');
    }
}
